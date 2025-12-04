<?php

namespace Database\Seeders;

use App\Models\SambutanContent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SambutanContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SambutanContent::firstOrCreate(
            ['id' => 1],
            [
                'hero_image' => 'assets/images/img1.png',
                'visi_image' => 'assets/images/visi.jpg',
                'visi_text' => 'Menjadi platform utama dalam pelestarian, pendokumentasian, dan promosi warisan budaya Sumbawa di era digital, sehingga dapat diakses dan diapresiasi oleh generasi sekarang dan mendatang.',
                'misi_image' => 'assets/images/misi.jpg',
                'misi_text' => '1. Mendokumentasikan karya-karya seniman Sumbawa secara terperinci
2. Melestarikan warisan budaya untuk generasi mendatang
3. Meningkatkan apresiasi masyarakat terhadap seni lokal
4. Mendukung pengembangan industri kreatif Sumbawa',
                'obj1_image' => 'assets/images/objective1.jpg',
                'obj1_title' => 'Dokumentasi Komprehensif',
                'obj1_deskripsi' => 'Menciptakan ensiklopedia digital karya seniman budaya Sumbawa yang dapat memberikan wawasan mendalam tentang kekayaan budaya lokal.',
                'obj2_image' => 'assets/images/objective2.jpg',
                'obj2_title' => 'Akses Mudah',
                'obj2_deskripsi' => 'Menghasilkan aplikasi yang memudahkan masyarakat lokal dan umum untuk mengakses informasi mengenai berbagai jenis kesenian Sumbawa.',
                'obj3_image' => 'assets/images/objective3.jpg',
                'obj3_title' => 'Promosi Budaya',
                'obj3_deskripsi' => 'Mendukung program pemerintah dalam mensosialisasikan keragaman budaya Sumbawa ke tingkat nasional dan internasional.',
                'obj4_image' => 'assets/images/objective4.jpg',
                'obj4_title' => 'Pelestarian Warisan',
                'obj4_deskripsi' => 'Memastikan bahwa warisan budaya Sumbawa terdokumentasi dengan baik untuk dilestarikan bagi generasi-generasi mendatang.',
            ]
        );
    }
}
