<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

echo '<h2>PHP Info</h2>';
echo 'PHP Version: ' . PHP_VERSION . '<br>';
echo 'Memory Limit: ' . ini_get('memory_limit') . '<br>';
echo 'Max Execution Time: ' . ini_get('max_execution_time') . '<br>';
echo 'Display Errors: ' . ini_get('display_errors') . '<br>';
echo '<br>';

echo '<h2>File Checks</h2>';
$base = dirname(__DIR__);
echo '.env exists: ' . (file_exists($base . '/.env') ? 'YES' : 'NO') . '<br>';
echo 'vendor/autoload.php exists: ' . (file_exists($base . '/vendor/autoload.php') ? 'YES' : 'NO') . '<br>';
echo 'storage writable: ' . (is_writable($base . '/storage') ? 'YES' : 'NO') . '<br>';
echo 'bootstrap/cache writable: ' . (is_writable($base . '/bootstrap/cache') ? 'YES' : 'NO') . '<br>';
echo '<br>';

echo '<h2>Loading Autoloader</h2>';
try {
    require $base . '/vendor/autoload.php';
    echo 'Autoloader: OK<br>';
} catch (\Throwable $e) {
    echo 'Autoloader ERROR: ' . $e->getMessage() . '<br>';
    exit;
}

echo '<br><h2>Booting Laravel</h2>';
try {
    $app = require_once $base . '/bootstrap/app.php';
    echo 'Bootstrap: OK<br>';
} catch (\Throwable $e) {
    echo 'Bootstrap ERROR: ' . $e->getMessage() . '<br>';
    echo 'File: ' . $e->getFile() . ':' . $e->getLine() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
