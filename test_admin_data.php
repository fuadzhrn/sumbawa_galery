<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use App\Models\KaryaSeni;
use App\Models\SliderImage;

echo "=== ADMIN DASHBOARD DATA ===\n";
echo "Total Seniman: " . User::where('role', 'seniman')->count() . "\n";
echo "Seniman Aktif: " . User::where('role', 'seniman')->where('is_active', 1)->count() . "\n";
echo "Total Karya (Approved): " . KaryaSeni::where('status', 'approved')->count() . "\n";
echo "Total Slider: " . SliderImage::count() . "\n";
