<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== KATEGORI ===\n";
$kategoris = DB::table('kategoris')->get();
echo "Total: " . count($kategoris) . "\n";
foreach ($kategoris as $k) {
    echo "- " . $k->nama . " (slug: " . $k->slug . ")\n";
}

echo "\n=== KARYA SENI ===\n";
$karya = DB::table('karya_senis')->get();
echo "Total: " . count($karya) . "\n";
foreach ($karya as $k) {
    echo "- " . $k->judul . " (kategori_id: " . $k->kategori_id . ", status: " . $k->status . ")\n";
}
