<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Seniman;
use App\Models\KaryaSeni;
use App\Models\Kategori;

class TestKaryaSeniSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create test user seniman
        $user = User::firstOrCreate(
            ['email' => 'seniman@test.com'],
            [
                'name' => 'Seniman Test',
                'password' => bcrypt('password'),
                'role' => 'seniman',
                'is_active' => true,
            ]
        );

        // Create seniman profile
        $kategoriMusik = Kategori::where('slug', 'musik')->first();
        if ($kategoriMusik && !$user->seniman) {
            Seniman::create([
                'user_id' => $user->id,
                'kategori_id' => $kategoriMusik->id,
                'nama' => $user->name,
                'biografi' => 'Saya adalah seniman musik tradisional Sumbawa',
                'foto' => 'assets/images/img1.png',
            ]);
        }

        // Create test karya seni for each kategori
        $kategoris = Kategori::all();
        $judul_samples = [
            'musik' => ['Lagu Tradisional Sumbawa', 'Musik Gending Sasak', 'Orkestra Sumbawa Modern'],
            'rupa' => ['Lukisan Motif Tradisional', 'Batik Sumbawa', 'Patung Kayu Unik'],
            'film' => ['Dokumenter Budaya Sumbawa', 'Film Cerita Pendek', 'Video Tari Tradisional'],
            'tari-tradisional' => ['Tari Peu-peu', 'Tari Gandrung', 'Tari Berkat'],
            'kerajinan-tangan' => ['Tenun Tradisional', 'Keramik Sumbawa', 'Anyaman Bambu'],
        ];

        foreach ($kategoris as $kategori) {
            $samples = $judul_samples[$kategori->slug] ?? ['Karya ' . $kategori->nama];
            
            foreach ($samples as $index => $judul) {
                $exists = KaryaSeni::where('kategori_id', $kategori->id)
                    ->where('judul', $judul)
                    ->exists();
                
                if (!$exists) {
                    KaryaSeni::create([
                        'user_id' => $user->id,
                        'kategori_id' => $kategori->id,
                        'judul' => $judul,
                        'deskripsi' => 'Karya seni ' . $kategori->nama . ' yang indah dan bermakna. Ini adalah karya test untuk menampilkan halaman kategori dengan benar.',
                        'media_type' => 'image',
                        'media_path' => 'assets/images/img' . (($index % 5) + 1) . '.png',
                        'thumbnail' => 'assets/images/img1.png',
                        'status' => 'approved',
                        'views' => rand(10, 100),
                        'likes' => rand(0, 50),
                    ]);
                }
            }
        }

        echo "Test karya seni created successfully!\n";
    }
}
