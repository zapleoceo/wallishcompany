<?php
echo "<h1>Startup.php Only Test</h1>";

// Load main config first
require_once('config.php');
echo "<p>✓ Main config loaded</p>";

// Load startup.php
echo "<h2>Loading startup.php</h2>";
try {
    require_once(DIR_SYSTEM . 'startup.php');
    echo "<p style='color: green;'>✓ startup.php loaded successfully</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}

echo "<h2>Test Completed</h2>";
?>
