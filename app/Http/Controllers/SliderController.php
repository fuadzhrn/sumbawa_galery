<?php

namespace App\Http\Controllers;

use App\Models\SliderImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:5120'
        ], [
            'foto.required' => 'Foto harus dipilih',
            'foto.image' => 'File harus berupa gambar',
            'foto.mimes' => 'Format gambar harus JPG atau PNG',
            'foto.max' => 'Ukuran gambar maksimal 5MB'
        ]);

        try {
            // Ensure slider directory exists
            $sliderDir = 'assets/slider';
            if (!Storage::disk('public')->exists($sliderDir)) {
                Storage::disk('public')->makeDirectory($sliderDir);
            }
            
            // Generate unique filename: slider-{timestamp}-{random}.{ext}
            $timestamp = time();
            $random = substr(uniqid(), -8);
            $extension = strtolower($request->file('foto')->getClientOriginalExtension());
            $filename = "slider-{$timestamp}-{$random}.{$extension}";
            
            // Store file
            $path = $request->file('foto')->storeAs($sliderDir, $filename, 'public');
            
            // Get next order
            $nextOrder = (SliderImage::max('order') ?? -1) + 1;
            
            // Create record
            $slider = SliderImage::create([
                'filename' => $filename,
                'original_name' => $request->file('foto')->getClientOriginalName(),
                'file_path' => 'storage/' . $path,
                'mime_type' => $request->file('foto')->getClientMimeType(),
                'file_size' => $request->file('foto')->getSize(),
                'description' => null,
                'order' => $nextOrder,
                'is_active' => true
            ]);

            return redirect()->route('admin.photo-slider')
                ->with('success', 'Foto slider berhasil ditambahkan!');
        } catch (\Exception $e) {
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
            
            // Delete file
            if (Storage::disk('public')->exists('assets/slider/' . $slider->filename)) {
                Storage::disk('public')->delete('assets/slider/' . $slider->filename);
            }
            
            // Delete record
            $slider->delete();

            return redirect()->route('admin.photo-slider')
                ->with('success', 'Foto slider berhasil dihapus! Total: ' . SliderImage::count() . ' foto');
        } catch (\Exception $e) {
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
