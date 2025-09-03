<?php
// Step 1: Load config.php first
require_once('config.php');

// Step 2: Check if DIR_APPLICATION is defined
if (!defined('DIR_APPLICATION')) {
    echo "ERROR: DIR_APPLICATION not defined!\n";
    exit;
}

echo "DIR_APPLICATION is defined: " . DIR_APPLICATION . "\n";

// Step 3: Load pdf/vendor/autoload.php
require_once 'pdf/vendor/autoload.php';
echo "PDF autoload loaded\n";

// Step 4: Load startup.php
require_once(DIR_SYSTEM . 'startup.php');
echo "Startup loaded\n";

// Step 5: Create Registry
$registry = new Registry();
echo "Registry created\n";

// Step 6: Create Loader
$loader = new Loader($registry);
echo "Loader created\n";

// Step 7: Create Config
$config = new Config();
echo "Config created\n";

// Step 8: Set config in registry
$registry->set('config', $config);
echo "Config set in registry\n";

echo "Test completed successfully!\n";
?>
