<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== KATEGORI ===\n";
$kategoris = DB::table('kategoris')->get();
foreach ($kategoris as $k) {
    echo "- " . $k->nama . " (id: " . $k->id . ", slug: " . $k->slug . ")\n";
}

echo "\n=== KARYA SENI PER KATEGORI ===\n";
foreach ($kategoris as $k) {
    $count = DB::table('karya_senis')->where('kategori_id', $k->id)->count();
    echo $k->nama . ": " . $count . " karya\n";
}

echo "\n=== TOTAL KARYA SENI ===\n";
$totalKarya = DB::table('karya_senis')->count();
echo "Total: " . $totalKarya . "\n";

echo "\n=== DETAIL KARYA SENI ===\n";
$karyaList = DB::table('karya_senis')->get();
foreach ($karyaList as $k) {
    $kategori = DB::table('kategoris')->where('id', $k->kategori_id)->first();
    echo "- " . $k->judul . " (kategori: " . ($kategori ? $kategori->nama : "N/A") . ", status: " . $k->status . ")\n";
}
