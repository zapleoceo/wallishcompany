<?php
echo "<h1>Debug System Config</h1>";

// Load main config first
require_once('config.php');
require_once(DIR_SYSTEM . 'startup.php');

echo "<p>✓ Main files loaded</p>";

// Check file content
echo "<h2>Checking file content</h2>";
$config_file = DIR_CONFIG . 'config.php';
echo "<p>File path: " . $config_file . "</p>";
echo "<p>File exists: " . (file_exists($config_file) ? 'YES' : 'NO') . "</p>";
echo "<p>File size: " . filesize($config_file) . " bytes</p>";

// Read first few lines
echo "<h2>First 10 lines:</h2>";
$lines = file($config_file);
for ($i = 0; $i < min(10, count($lines)); $i++) {
    echo "<p>" . ($i + 1) . ": " . htmlspecialchars(trim($lines[$i])) . "</p>";
}

// Try to load with error reporting
echo "<h2>Loading with error reporting:</h2>";
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    $result = require_once($config_file);
    echo "<p style='color: green;'>✓ system/config/config.php loaded successfully</p>";
} catch (ParseError $e) {
    echo "<p style='color: red;'>✗ Parse Error: " . $e->getMessage() . "</p>";
    echo "<p>Line: " . $e->getLine() . "</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Exception: " . $e->getMessage() . "</p>";
}

echo "<h2>Test Completed</h2>";
?>
