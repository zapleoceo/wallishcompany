<?php
echo "<h1>Index.php Step-by-Step Test</h1>";

// Step 1: Load config.php
echo "<h2>Step 1: Loading config.php</h2>";
require_once('config.php');
echo "<p>✓ config.php loaded</p>";

// Step 2: Check DIR_APPLICATION
echo "<h2>Step 2: Checking DIR_APPLICATION</h2>";
if (!defined('DIR_APPLICATION')) {
    echo "<p style='color: red;'>✗ DIR_APPLICATION not defined - would redirect to install</p>";
    exit;
}
echo "<p style='color: green;'>✓ DIR_APPLICATION defined: " . DIR_APPLICATION . "</p>";

// Step 3: Load pdf/vendor/autoload.php
echo "<h2>Step 3: Loading PDF autoload</h2>";
require_once 'pdf/vendor/autoload.php';
echo "<p>✓ PDF autoload loaded</p>";

// Step 4: Load startup.php
echo "<h2>Step 4: Loading startup.php</h2>";
require_once(DIR_SYSTEM . 'startup.php');
echo "<p>✓ startup.php loaded</p>";

// Step 5: Create Registry
echo "<h2>Step 5: Creating Registry</h2>";
$registry = new Registry();
echo "<p>✓ Registry created</p>";

// Step 6: Create Loader
echo "<h2>Step 6: Creating Loader</h2>";
$loader = new Loader($registry);
echo "<p>✓ Loader created</p>";

// Step 7: Create Config
echo "<h2>Step 7: Creating Config</h2>";
$config = new Config();
echo "<p>✓ Config created</p>";

// Step 8: Set config in registry
echo "<h2>Step 8: Setting config in registry</h2>";
$registry->set('config', $config);
echo "<p>✓ Config set in registry</p>";

echo "<h2>All Steps Completed Successfully!</h2>";
echo "<p>If you see this message, index.php should work!</p>";
?>
