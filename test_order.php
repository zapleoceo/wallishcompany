<?php
echo "<h1>File Loading Order Test</h1>";

// Step 1: Load main config.php
echo "<h2>Step 1: Loading main config.php</h2>";
require_once('config.php');
echo "<p>✓ Main config.php loaded</p>";

// Step 2: Check constants
echo "<h2>Step 2: Checking constants</h2>";
echo "<p>DIR_SYSTEM: " . (defined('DIR_SYSTEM') ? DIR_SYSTEM : 'NOT DEFINED') . "</p>";
echo "<p>DIR_CONFIG: " . (defined('DIR_CONFIG') ? DIR_CONFIG : 'NOT DEFINED') . "</p>";

// Step 3: Load startup.php
echo "<h2>Step 3: Loading startup.php</h2>";
require_once(DIR_SYSTEM . 'startup.php');
echo "<p>✓ startup.php loaded</p>";

// Step 4: Check if Config class exists
echo "<h2>Step 4: Checking Config class</h2>";
echo "<p>Config class exists: " . (class_exists('Config') ? 'YES' : 'NO') . "</p>";

// Step 5: Try to create Config object
echo "<h2>Step 5: Creating Config object</h2>";
try {
    $config = new Config();
    echo "<p style='color: green;'>✓ Config object created</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}

// Step 6: Now try to load system/config/config.php
echo "<h2>Step 6: Loading system/config/config.php</h2>";
try {
    require_once(DIR_CONFIG . 'config.php');
    echo "<p style='color: green;'>✓ system/config/config.php loaded</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}

echo "<h2>Test Completed</h2>";
?>
