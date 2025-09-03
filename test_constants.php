<?php
echo "Testing constants loading...\n";

echo "Before loading config.php:\n";
echo "DIR_APPLICATION defined: " . (defined('DIR_APPLICATION') ? 'YES' : 'NO') . "\n";
echo "DIR_SYSTEM defined: " . (defined('DIR_SYSTEM') ? 'YES' : 'NO') . "\n";

echo "\nLoading config.php...\n";
require_once 'config.php';

echo "\nAfter loading config.php:\n";
echo "DIR_APPLICATION defined: " . (defined('DIR_APPLICATION') ? 'YES' : 'NO') . "\n";
echo "DIR_SYSTEM defined: " . (defined('DIR_SYSTEM') ? 'YES' : 'NO') . "\n";

if (defined('DIR_APPLICATION')) {
    echo "DIR_APPLICATION value: " . DIR_APPLICATION . "\n";
}
if (defined('DIR_SYSTEM')) {
    echo "DIR_SYSTEM value: " . DIR_SYSTEM . "\n";
}

echo "\nTest completed!\n";
?>
