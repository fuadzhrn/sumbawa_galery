<?php

namespace App\Http\Controllers;

use App\Models\SliderImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SliderController extends Controller
{
    /**
     * Tampilkan halaman manajemen photo slider
     */
    public function index()
    {
        $sliders = SliderImage::orderBy('order')->get();
        return view('admin.photo-slider', compact('sliders'));
    }

    /**
     * Upload foto slider baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:5120'
        ], [
            'foto.required' => 'Foto harus dipilih',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format gambar harus JPG atau PNG',
            'foto.max' => 'Ukuran gambar maksimal 5MB'
        ]);

        try {
            // Ensure slider directory exists in public/assets
            $sliderDir = public_path('assets/slider');
            if (!is_dir($sliderDir)) {
                mkdir($sliderDir, 0755, true);
                Log::info('Slider directory created at: ' . $sliderDir);
            }
            
            // Get file info BEFORE moving (temp file will be deleted after)
            $fileSize = $request->file('foto')->getSize();
            $mimeType = $request->file('foto')->getClientMimeType();
            $originalName = $request->file('foto')->getClientOriginalName();
            
            Log::info('Slider Upload Started', [
                'original_name' => $originalName,
                'mime_type' => $mimeType,
                'file_size' => $fileSize,
                'slider_dir' => $sliderDir,
                'dir_exists' => is_dir($sliderDir),
                'dir_writable' => is_writable($sliderDir)
            ]);
            
            // Generate unique filename: slider-{timestamp}-{random}.{ext}
            $timestamp = time();
            $random = substr(uniqid(), -8);
            $extension = strtolower($request->file('foto')->getClientOriginalExtension());
            $filename = "slider-{$timestamp}-{$random}.{$extension}";
            
            Log::info('Generated filename: ' . $filename);
            
            // Move file to public/assets/slider
            $moved = $request->file('foto')->move($sliderDir, $filename);
            
            if (!$moved) {
                throw new \Exception('Gagal memindahkan file ke direktori slider');
            }
            
            // Verify file exists after move
            $fullPath = $sliderDir . DIRECTORY_SEPARATOR . $filename;
            if (!file_exists($fullPath)) {
                throw new \Exception('File tidak ditemukan setelah upload di: ' . $fullPath);
            }
            
            Log::info('File successfully moved to: ' . $fullPath);
            
            // Get next order
            $nextOrder = (SliderImage::max('order') ?? -1) + 1;
            
            // Create record - store path as assets/slider/filename
            $filePath = 'assets/slider/' . $filename;
            $slider = SliderImage::create([
                'filename' => $filename,
                'original_name' => $originalName,
                'file_path' => $filePath,
                'mime_type' => $mimeType,
                'file_size' => $fileSize,
                'description' => null,
                'order' => $nextOrder,
                'is_active' => true
            ]);

            if (!$slider) {
                throw new \Exception('Gagal menyimpan data slider ke database');
            }

            Log::info('Slider record created', [
                'id' => $slider->id,
                'file_path' => $slider->file_path,
                'full_url' => asset($slider->file_path)
            ]);

            // For AJAX requests, return JSON response
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Foto slider berhasil ditambahkan!',
                    'slider' => $slider
                ], 200);
            }

            return redirect()->route('admin.photo-slider')
                ->with('success', 'Foto slider berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Slider Upload Error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTrace()
            ]);

            // For AJAX requests, return JSON error response
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengunggah foto: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.photo-slider')
                ->with('error', 'Gagal mengunggah foto: ' . $e->getMessage());
        }
    }

    /**
     * Hapus foto slider
     */
    public function destroy($id)
    {
        try {
            $slider = SliderImage::findOrFail($id);
            
            // Delete file from public/assets/slider
            $filePath = public_path('assets/slider/' . $slider->filename);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            
            // Delete record
            $slider->delete();

            // For AJAX requests, return JSON response
            if (request()->wantsJson() || request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Foto slider berhasil dihapus!'
                ], 200);
            }

            return redirect()->route('admin.photo-slider')
                ->with('success', 'Foto slider berhasil dihapus! Total: ' . SliderImage::count() . ' foto');
        } catch (\Exception $e) {
            // For AJAX requests, return JSON error response
            if (request()->wantsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus foto: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.photo-slider')
                ->with('error', 'Gagal menghapus foto: ' . $e->getMessage());
        }
    }

    /**
     * Update deskripsi slider
     */
    public function updateDescription(Request $request, $id)
    {
        $request->validate([
            'deskripsi' => 'nullable|string|max:255'
        ]);

        try {
            $slider = SliderImage::findOrFail($id);
            $slider->update(['description' => $request->input('deskripsi')]);

            return response()->json([
                'success' => true,
                'message' => 'Deskripsi berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui deskripsi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get semua slider untuk API (public)
     */
    public function getActive()
    {
        $sliders = SliderImage::where('is_active', true)
            ->orderBy('order')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $sliders,
            'count' => $sliders->count()
        ]);
    }

    /**
     * Reorder slider images
     */
    public function reorder(Request $request)
    {
        try {
            $orders = $request->input('orders', []);
            
            foreach ($orders as $index => $sliderId) {
                SliderImage::where('id', $sliderId)->update(['order' => $index]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Urutan slider berhasil diperbarui'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui urutan: ' . $e->getMessage()
            ], 500);
        }
    }
}
