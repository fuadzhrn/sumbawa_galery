<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\KaryaSeni;
use App\Models\Kategori;

echo "=== KATEGORI ===\n";
$kategoris = Kategori::all();
foreach ($kategoris as $k) {
    echo "- " . $k->nama . " (id: " . $k->id . ", slug: " . $k->slug . ")\n";
}

echo "\n=== KARYA SENI PER KATEGORI ===\n";
foreach ($kategoris as $k) {
    $count = KaryaSeni::where('kategori_id', $k->id)->count();
    echo $k->nama . ": " . $count . " karya\n";
}

echo "\n=== TOTAL KARYA SENI ===\n";
$totalKarya = KaryaSeni::count();
echo "Total: " . $totalKarya . "\n";

echo "\n=== TEST KATEGORI BAMBANG ===\n";
$bambang = Kategori::where('slug', 'bambang')->first();
if ($bambang) {
    echo "Kategori ditemukan: " . $bambang->nama . "\n";
    $karya = KaryaSeni::where('kategori_id', $bambang->id)->where('status', 'approved')->get();
    echo "Karya approved: " . count($karya) . "\n";
} else {
    echo "Kategori bambang tidak ditemukan\n";
}
