<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "=== DATABASE STATUS ===\n\n";

// Check if tables exist
$tables = ['users', 'slider_images', 'migrations', 'sessions', 'cache', 'jobs'];

foreach ($tables as $table) {
    $exists = Schema::hasTable($table);
    echo "Table '{$table}': " . ($exists ? "✓ EXISTS" : "✗ MISSING") . "\n";
}

echo "\n=== DATA COUNT ===\n\n";

if (Schema::hasTable('users')) {
    $userCount = DB::table('users')->count();
    echo "Users: {$userCount}\n";
}

if (Schema::hasTable('slider_images')) {
    $sliderCount = DB::table('slider_images')->count();
    echo "Slider Images: {$sliderCount}\n";
}

echo "\n=== ADMIN USER CHECK ===\n\n";

if (Schema::hasTable('users')) {
    $admin = DB::table('users')->where('email', 'admin@sumbawa.com')->first();
    if ($admin) {
        echo "Admin User: FOUND\n";
        echo "Name: {$admin->name}\n";
        echo "Email: {$admin->email}\n";
        echo "Role: {$admin->role}\n";
    } else {
        echo "Admin User: NOT FOUND\n";
    }
}

echo "\n";
