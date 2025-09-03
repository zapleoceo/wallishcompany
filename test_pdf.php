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

echo "Test completed successfully!\n";
?>
