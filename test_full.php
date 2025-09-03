<?php
echo "Step 1: Loading config.php...\n";
require_once 'config.php';
echo "Step 2: Config loaded\n";

echo "Step 3: Loading pdf/vendor/autoload.php...\n";
require_once 'pdf/vendor/autoload.php';
echo "Step 4: PDF autoload loaded\n";

echo "Step 5: Loading startup.php...\n";
require_once(DIR_SYSTEM . 'startup.php');
echo "Step 6: Startup loaded\n";

echo "Step 7: Creating Registry...\n";
$registry = new Registry();
echo "Step 8: Registry created\n";

echo "Step 9: Creating Loader...\n";
$loader = new Loader($registry);
echo "Step 10: Loader created\n";

echo "Step 11: Creating Config...\n";
$config = new Config();
echo "Step 12: Config created\n";

echo "Step 13: Setting config in registry...\n";
$registry->set('config', $config);
echo "Step 14: Config set in registry\n";

echo "Step 15: Creating DB...\n";
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
echo "Step 16: DB created\n";

echo "Step 17: Setting DB in registry...\n";
$registry->set('db', $db);
echo "Step 18: DB set in registry\n";

echo "Test completed successfully!\n";
?>
