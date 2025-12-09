<?php
// Check karya seni paths
$dbFile = __DIR__ . '/database_schema.sql';
if (file_exists($dbFile)) {
    echo "Database schema file exists\n";
}

// Simple check
$karyaFile = __DIR__ . '/public/assets/karya_seni/5/karya-1764942513-2b1d30dd.jpeg';
echo "Checking: " . $karyaFile . "\n";
echo "Exists: " . (file_exists($karyaFile) ? "YES" : "NO") . "\n";

$thumbFile = __DIR__ . '/public/assets/thumbnails/5/thumb-1764942513-2b1d3a9f.jpg';
echo "Checking: " . $thumbFile . "\n";
echo "Exists: " . (file_exists($thumbFile) ? "YES" : "NO") . "\n";
?>
