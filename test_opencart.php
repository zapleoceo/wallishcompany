<?php
// Test OpenCart loading
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Testing OpenCart loading...\n";

// Define basic constants
define('DIR_APPLICATION', __DIR__ . '/catalog/');
define('DIR_SYSTEM', __DIR__ . '/system/');
define('DIR_LANGUAGE', __DIR__ . '/catalog/language/');
define('DIR_TEMPLATE', __DIR__ . '/catalog/view/theme/');
define('DIR_CONFIG', __DIR__ . '/system/config/');
define('DIR_IMAGE', __DIR__ . '/image/');
define('DIR_CACHE', __DIR__ . '/system/storage/cache/');
define('DIR_DOWNLOAD', __DIR__ . '/system/storage/download/');
define('DIR_LOGS', __DIR__ . '/system/storage/logs/');
define('DIR_MODIFICATION', __DIR__ . '/system/storage/modification/');
define('DIR_UPLOAD', __DIR__ . '/system/storage/upload/');

echo "Constants defined.\n";

// Load startup
if (file_exists(DIR_SYSTEM . 'startup.php')) {
    echo "Loading startup.php...\n";
    require_once(DIR_SYSTEM . 'startup.php');
    echo "Startup loaded.\n";
} else {
    echo "ERROR: startup.php not found!\n";
    exit;
}

// Test if classes are loaded
if (class_exists('Config')) {
    echo "SUCCESS: Config class loaded!\n";
} else {
    echo "ERROR: Config class not found!\n";
}

if (class_exists('Registry')) {
    echo "SUCCESS: Registry class loaded!\n";
} else {
    echo "ERROR: Registry class not found!\n";
}

if (class_exists('Loader')) {
    echo "SUCCESS: Loader class loaded!\n";
} else {
    echo "ERROR: Loader class not found!\n";
}

echo "Test completed.\n";
?>
