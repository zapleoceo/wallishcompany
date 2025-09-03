<?php
echo "<h1>Autoloader Test</h1>";

// Load config first
require_once 'config.php';
echo "<p>✓ config.php loaded</p>";

// Load startup
require_once(DIR_SYSTEM . 'startup.php');
echo "<p>✓ startup.php loaded</p>";

// Check if autoloader is registered
echo "<p>Autoloader functions registered:</p>";
$autoloaders = spl_autoload_functions();
foreach ($autoloaders as $autoloader) {
    if (is_string($autoloader)) {
        echo "<p>- " . $autoloader . "</p>";
    } else {
        echo "<p>- Closure/Array</p>";
    }
}

// Test if Config class exists
echo "<p>Config class exists: " . (class_exists('Config') ? 'YES' : 'NO') . "</p>";

// Try to create Config object
try {
    $config = new Config();
    echo "<p style='color: green;'>✓ Config object created successfully</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error creating Config: " . $e->getMessage() . "</p>";
}

echo "<h2>Test Completed</h2>";
?>
