<?php
// Test karya seni data
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);

$request = \Illuminate\Http\Request::capture();
$response = $kernel->handle($request);

// Simple database test
try {
    $db = new PDO('mysql:host=127.0.0.1;dbname=galery_sumbawa', 'root', '');
    $stmt = $db->prepare('SELECT id, judul, media_type, media_path, thumbnail, status FROM karya_seni LIMIT 3');
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h2>Karya Seni Data</h2>";
    echo "<pre>";
    print_r($results);
    echo "</pre>";
    
    // Check if files exist
    echo "<h2>File Existence Check</h2>";
    foreach ($results as $karya) {
        if ($karya['media_path']) {
            $filepath = __DIR__ . '/' . $karya['media_path'];
            $exists = file_exists($filepath) ? 'YES' : 'NO';
            echo "<p>ID: {$karya['id']} | Path: {$karya['media_path']} | Exists: {$exists}</p>";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
