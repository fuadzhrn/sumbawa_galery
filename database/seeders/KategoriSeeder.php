<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            'Musik',
            'Rupa',
            'Film',
            'Tari Tradisional',
            'Kerajinan Tangan',
        ];

        foreach ($kategoris as $nama) {
            // Hanya create jika belum ada
            if (!Kategori::where('slug', \Illuminate\Support\Str::slug($nama))->exists()) {
                Kategori::create([
                    'nama' => $nama,
                    'slug' => Str::slug($nama),
                ]);
            }
        }
    }
}
