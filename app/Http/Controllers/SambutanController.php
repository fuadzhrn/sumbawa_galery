<?php

namespace App\Http\Controllers;

use App\Models\SambutanContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SambutanController extends Controller
{
    /**
     * Show sambutan page (user view)
     */
    public function show()
    {
        $sambutan = SambutanContent::getOrCreate();
        return view('sambutan', compact('sambutan'));
    }

    /**
     * Show admin edit page
     */
    public function edit()
    {
        $sambutan = SambutanContent::getOrCreate();
        return view('admin.kata-sambutan', compact('sambutan'));
    }

    /**
     * Update sambutan content
     */
    public function update(Request $request)
    {
        $sambutan = SambutanContent::getOrCreate();

        // Validate inputs
        $validated = $request->validate([
            'hero_image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'visi_text' => 'nullable|string|max:1000',
            'misi_text' => 'nullable|string|max:1000',
            'obj1_title' => 'nullable|string|max:200',
            'obj1_deskripsi' => 'nullable|string|max:500',
            'obj2_title' => 'nullable|string|max:200',
            'obj2_deskripsi' => 'nullable|string|max:500',
            'obj3_title' => 'nullable|string|max:200',
            'obj3_deskripsi' => 'nullable|string|max:500',
            'obj4_title' => 'nullable|string|max:200',
            'obj4_deskripsi' => 'nullable|string|max:500',
        ]);

        try {
            // Handle file uploads for hero image only
            if ($request->hasFile('hero_image')) {
                // Delete old file if exists and is not a default asset
                if ($sambutan->hero_image && !str_starts_with($sambutan->hero_image, 'assets/images/')) {
                    $oldFilePath = public_path($sambutan->hero_image);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                // Store new file with random name
                $file = $request->file('hero_image');
                $sambutanDir = public_path('assets/sambutan');
                
                // Create directory if it doesn't exist
                if (!is_dir($sambutanDir)) {
                    mkdir($sambutanDir, 0755, true);
                }
                
                $timestamp = time();
                $random = substr(uniqid(), -8);
                $extension = strtolower($file->getClientOriginalExtension());
                $filename = "sambutan-{$timestamp}-{$random}.{$extension}";
                
                $moved = $file->move($sambutanDir, $filename);
                if (!$moved) {
                    throw new \Exception("Gagal memindahkan file hero_image");
                }
                $validated['hero_image'] = 'assets/sambutan/' . $filename;
            }

            // Update only provided fields
            $updated = $sambutan->update($validated);
            
            if (!$updated) {
                throw new \Exception('Gagal menyimpan data sambutan ke database');
            }

            return redirect()->route('sambutan.edit')
                ->with('success', 'Konten sambutan berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Sambutan Update Error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return redirect()->back()
                ->with('error', 'Gagal memperbarui sambutan: ' . $e->getMessage())
                ->withInput();
        }
    }
}
