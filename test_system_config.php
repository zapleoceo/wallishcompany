<?php
echo "<h1>System Config Test</h1>";

// Load main config first
require_once('config.php');
require_once(DIR_SYSTEM . 'startup.php');

echo "<p>✓ Main files loaded</p>";

// Try to load system/config/config.php
echo "<h2>Loading system/config/config.php</h2>";
try {
    $result = require_once(DIR_CONFIG . 'config.php');
    echo "<p style='color: green;'>✓ system/config/config.php loaded successfully</p>";
    echo "<p>Return value: " . ($result ? 'TRUE' : 'FALSE') . "</p>";
} catch (ParseError $e) {
    echo "<p style='color: red;'>✗ Parse Error: " . $e->getMessage() . "</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Exception: " . $e->getMessage() . "</p>";
}

echo "<h2>Test Completed</h2>";
?>
