<?php

namespace App\Http\Controllers;

use App\Models\SambutanContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'visi_image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'visi_text' => 'nullable|string|max:1000',
            'misi_image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'misi_text' => 'nullable|string|max:1000',
            'obj1_image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'obj1_title' => 'nullable|string|max:200',
            'obj1_deskripsi' => 'nullable|string|max:500',
            'obj2_image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'obj2_title' => 'nullable|string|max:200',
            'obj2_deskripsi' => 'nullable|string|max:500',
            'obj3_image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'obj3_title' => 'nullable|string|max:200',
            'obj3_deskripsi' => 'nullable|string|max:500',
            'obj4_image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            'obj4_title' => 'nullable|string|max:200',
            'obj4_deskripsi' => 'nullable|string|max:500',
        ]);

        // Handle file uploads for images with random naming
        $imageFields = [
            'hero_image',
            'visi_image',
            'misi_image',
            'obj1_image',
            'obj2_image',
            'obj3_image',
            'obj4_image',
        ];

        foreach ($imageFields as $field) {
            if ($request->hasFile($field)) {
                // Delete old file if exists and is not a default asset
                if ($sambutan->$field && !str_starts_with($sambutan->$field, 'assets/images/')) {
                    if (Storage::exists('public/' . $sambutan->$field)) {
                        Storage::delete('public/' . $sambutan->$field);
                    }
                }

                // Store new file with random name
                $file = $request->file($field);
                $timestamp = time();
                $random = substr(uniqid(), -8);
                $extension = strtolower($file->getClientOriginalExtension());
                $filename = "sambutan-{$timestamp}-{$random}.{$extension}";
                
                $path = $file->storeAs('assets/sambutan', $filename, 'public');
                $validated[$field] = $path;
            }
        }

        // Update only provided fields
        $sambutan->update($validated);

        return redirect()->route('sambutan.edit')
            ->with('success', 'Konten sambutan berhasil diperbarui!');
    }
}
