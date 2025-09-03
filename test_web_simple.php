<?php
// Simple test to check if web server can load files
echo "Web server test started\n";

// Check if we can load config
if (file_exists('config.php')) {
    echo "config.php exists\n";
    require_once 'config.php';
    echo "config.php loaded\n";
    
    if (defined('DIR_SYSTEM')) {
        echo "DIR_SYSTEM defined: " . DIR_SYSTEM . "\n";
    } else {
        echo "DIR_SYSTEM NOT defined\n";
    }
} else {
    echo "config.php NOT found\n";
}

echo "Test completed\n";
?>
