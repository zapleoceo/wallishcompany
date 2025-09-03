<?php
echo "Step 1: Loading config.php...\n";
require_once 'config.php';
echo "Step 2: Config loaded, DIR_SYSTEM = " . DIR_SYSTEM . "\n";

echo "Step 3: Loading startup.php...\n";
require_once(DIR_SYSTEM . 'startup.php');
echo "Step 4: Startup loaded\n";

echo "Step 5: Creating Registry...\n";
$registry = new Registry();
echo "Step 6: Registry created\n";

echo "Step 7: Creating Loader...\n";
$loader = new Loader($registry);
echo "Step 8: Loader created\n";

echo "Step 9: Creating Config...\n";
$config = new Config();
echo "Step 10: Config created\n";

echo "Step 11: Setting config in registry...\n";
$registry->set('config', $config);
echo "Step 12: Config set in registry\n";

echo "Test completed successfully!\n";
?>
