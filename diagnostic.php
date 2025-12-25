<?php
/**
 * TEST TOGGLE BUTTON FUNCTIONALITY
 * File ini membantu debugging toggle button
 */

// Check file structure
$files = [
    'public/js/script.js' => file_exists(__DIR__ . '/public/js/script.js'),
    'public/css/style.css' => file_exists(__DIR__ . '/public/css/style.css'),
    'resources/views/layouts/app.blade.php' => file_exists(__DIR__ . '/resources/views/layouts/app.blade.php'),
];

// Check JavaScript function
$scriptContent = file_get_contents(__DIR__ . '/public/js/script.js');
$hasInitSidebarToggle = strpos($scriptContent, 'function initSidebarToggle()') !== false;
$hasEventListener = strpos($scriptContent, "getElementById('sidebarToggle')") !== false;
$hasConsoleLog = strpos($scriptContent, "console.log") !== false;

// Check CSS
$cssContent = file_get_contents(__DIR__ . '/public/css/style.css');
$hasSidebarToggleCSS = strpos($cssContent, '.sidebar-toggle') !== false;
$hasMediaQuery = strpos($cssContent, '@media (max-width: 767px)') !== false;

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toggle Button Diagnostic Report</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 900px;
            margin: 2rem auto;
            padding: 0 1rem;
            background: #f5f5f5;
        }
        
        .container {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        h1 {
            color: #333;
            border-bottom: 3px solid #1e88e5;
            padding-bottom: 1rem;
        }
        
        .check-section {
            margin: 1.5rem 0;
            padding: 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .check-section h2 {
            color: #1e88e5;
            font-size: 1.1rem;
            margin: 0 0 0.5rem 0;
        }
        
        .check-item {
            margin: 0.5rem 0;
            padding: 0.5rem 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }
        
        .icon {
            font-size: 1.2rem;
            font-weight: bold;
            width: 24px;
            text-align: center;
        }
        
        .success .icon {
            color: #4caf50;
        }
        
        .error .icon {
            color: #f44336;
        }
        
        .warning .icon {
            color: #ff9800;
        }
        
        .status {
            flex: 1;
        }
        
        .code-block {
            background: #f5f5f5;
            padding: 0.75rem;
            border-radius: 4px;
            font-family: monospace;
            font-size: 0.9rem;
            margin-top: 0.5rem;
            overflow-x: auto;
        }
        
        .summary {
            background: #e3f2fd;
            border: 2px solid #1e88e5;
            padding: 1rem;
            border-radius: 4px;
            margin-top: 2rem;
        }
        
        .summary h3 {
            color: #1e88e5;
            margin: 0 0 0.5rem 0;
        }
        
        .next-steps {
            background: #fff9c4;
            border: 2px solid #ff9800;
            padding: 1rem;
            border-radius: 4px;
            margin-top: 1rem;
        }
        
        .next-steps h3 {
            color: #ff6f00;
            margin: 0 0 0.5rem 0;
        }
        
        .next-steps ol {
            margin: 0;
            padding-left: 1.5rem;
        }
        
        .next-steps li {
            margin: 0.3rem 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Toggle Button Diagnostic Report</h1>
        
        <div class="check-section">
            <h2>1. File Verification</h2>
            <?php foreach ($files as $file => $exists): ?>
                <div class="check-item <?php echo $exists ? 'success' : 'error'; ?>">
                    <div class="icon"><?php echo $exists ? '✓' : '✗'; ?></div>
                    <div class="status"><?php echo $file; ?></div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <div class="check-section">
            <h2>2. JavaScript Implementation</h2>
            <div class="check-item <?php echo $hasInitSidebarToggle ? 'success' : 'error'; ?>">
                <div class="icon"><?php echo $hasInitSidebarToggle ? '✓' : '✗'; ?></div>
                <div class="status">Function initSidebarToggle() exists</div>
            </div>
            <div class="check-item <?php echo $hasEventListener ? 'success' : 'error'; ?>">
                <div class="icon"><?php echo $hasEventListener ? '✓' : '✗'; ?></div>
                <div class="status">getElementById('sidebarToggle') event listener found</div>
            </div>
            <div class="check-item <?php echo $hasConsoleLog ? 'success' : 'error'; ?>">
                <div class="icon"><?php echo $hasConsoleLog ? '✓' : '✗'; ?></div>
                <div class="status">Debug console.log statements present</div>
            </div>
        </div>
        
        <div class="check-section">
            <h2>3. CSS Implementation</h2>
            <div class="check-item <?php echo $hasSidebarToggleCSS ? 'success' : 'error'; ?>">
                <div class="icon"><?php echo $hasSidebarToggleCSS ? '✓' : '✗'; ?></div>
                <div class="status">.sidebar-toggle CSS class defined</div>
            </div>
            <div class="check-item <?php echo $hasMediaQuery ? 'success' : 'error'; ?>">
                <div class="icon"><?php echo $hasMediaQuery ? '✓' : '✗'; ?></div>
                <div class="status">Mobile media query (@media max-width: 767px) found</div>
            </div>
        </div>
        
        <div class="check-section">
            <h2>4. What to Check Next</h2>
            <div class="next-steps">
                <h3>Steps to Debug:</h3>
                <ol>
                    <li>Open your app in mobile view (DevTools F12)</li>
                    <li>Set viewport width to 480px or less</li>
                    <li>Open Browser Console (F12 > Console tab)</li>
                    <li>Look for messages starting with <code>[DEBUG]</code> and <code>[initSidebarToggle]</code></li>
                    <li>Check if button element is visible in the DOM</li>
                    <li>Try clicking the hamburger icon and watch for event logs</li>
                </ol>
            </div>
        </div>
        
        <div class="summary">
            <h3>📋 Summary</h3>
            <?php
                $allFiles = array_reduce($files, fn($carry, $item) => $carry && $item, true);
                $allJS = $hasInitSidebarToggle && $hasEventListener && $hasConsoleLog;
                $allCSS = $hasSidebarToggleCSS && $hasMediaQuery;
                $allGood = $allFiles && $allJS && $allCSS;
            ?>
            <p>
                <strong>Files:</strong> <?php echo $allFiles ? '✓ All present' : '✗ Missing files'; ?><br>
                <strong>JavaScript:</strong> <?php echo $allJS ? '✓ Properly implemented' : '✗ Issues found'; ?><br>
                <strong>CSS:</strong> <?php echo $allCSS ? '✓ Properly implemented' : '✗ Issues found'; ?><br>
                <strong>Overall:</strong> <?php echo $allGood ? '✓ Everything looks good!' : '⚠️ Issues detected'; ?>
            </p>
        </div>
    </div>
</body>
</html>
