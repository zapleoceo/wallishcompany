<?php
// Test loading index.php through web server
echo "<h1>Index.php Web Test</h1>";

// Capture output
ob_start();

// Load index.php
include 'index.php';

// Get output
$output = ob_get_clean();

echo "<p>Output length: " . strlen($output) . " characters</p>";
echo "<p>First 1000 characters:</p>";
echo "<pre>" . htmlspecialchars(substr($output, 0, 1000)) . "</pre>";

echo "<h2>Test Completed</h2>";
?>
