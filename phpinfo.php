<?php
// Test PHP info in browser
echo "<h1>PHP Info Test</h1>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Server Software: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";
echo "<p>Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
echo "<p>Script Filename: " . $_SERVER['SCRIPT_FILENAME'] . "</p>";

// Test if we can load OpenCart files
echo "<h2>OpenCart Files Test</h2>";

if (file_exists('config.php')) {
    echo "<p style='color: green;'>✓ config.php exists</p>";
    
    // Try to load config
    try {
        require_once 'config.php';
        echo "<p style='color: green;'>✓ config.php loaded successfully</p>";
        
        if (defined('DIR_SYSTEM')) {
            echo "<p style='color: green;'>✓ DIR_SYSTEM defined: " . DIR_SYSTEM . "</p>";
        } else {
            echo "<p style='color: red;'>✗ DIR_SYSTEM NOT defined</p>";
        }
        
        if (defined('DIR_APPLICATION')) {
            echo "<p style='color: green;'>✓ DIR_APPLICATION defined: " . DIR_APPLICATION . "</p>";
        } else {
            echo "<p style='color: red;'>✗ DIR_APPLICATION NOT defined</p>";
        }
        
    } catch (Exception $e) {
        echo "<p style='color: red;'>✗ Error loading config.php: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p style='color: red;'>✗ config.php NOT found</p>";
}

// Test system files
echo "<h2>System Files Test</h2>";
$system_path = defined('DIR_SYSTEM') ? DIR_SYSTEM : 'system/';

if (file_exists($system_path . 'startup.php')) {
    echo "<p style='color: green;'>✓ startup.php exists</p>";
} else {
    echo "<p style='color: red;'>✗ startup.php NOT found</p>";
}

if (file_exists($system_path . 'library/config.php')) {
    echo "<p style='color: green;'>✓ system/library/config.php exists</p>";
} else {
    echo "<p style='color: red;'>✗ system/library/config.php NOT found</p>";
}

// Test if we can create objects
echo "<h2>Class Loading Test</h2>";
try {
    require_once($system_path . 'startup.php');
    echo "<p style='color: green;'>✓ startup.php loaded</p>";
    
    $registry = new Registry();
    echo "<p style='color: green;'>✓ Registry created</p>";
    
    $config = new Config();
    echo "<p style='color: green;'>✓ Config created</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}

echo "<h2>Test Completed</h2>";
?>
