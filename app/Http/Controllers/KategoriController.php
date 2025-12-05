<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoris = Kategori::all();
        return view('admin.kategori', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|unique:kategoris,nama',
        ]);

        Kategori::create([
            'nama' => $validated['nama_kategori'],
            'slug' => Str::slug($validated['nama_kategori']),
        ]);

        return redirect('/admin/kategori')->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $kategori)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|unique:kategoris,nama,' . $kategori->id,
        ]);

        $kategori->update([
            'nama' => $validated['nama_kategori'],
            'slug' => Str::slug($validated['nama_kategori']),
        ]);

        return redirect('/admin/kategori')->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        $kategori->delete();
        return redirect('/admin/kategori')->with('success', 'Kategori berhasil dihapus!');
    }
}
