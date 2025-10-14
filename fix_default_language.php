<?php
require_once 'config.php';
require_once 'system/startup.php';

$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);

echo "=== FIXING DEFAULT LANGUAGE ===\n";

// Check current default language
$config_query = $db->query("SELECT * FROM oc_setting WHERE `key` = 'config_language'");
if ($config_query->num_rows) {
    echo "Current default language: " . $config_query->row['value'] . "\n";
} else {
    echo "No default language setting found\n";
}

// Change default language to Ukrainian
$result = $db->query("UPDATE oc_setting SET value = 'uk' WHERE `key` = 'config_language'");

if ($db->countAffected() > 0) {
    echo "✅ Default language changed to Ukrainian (uk)\n";
} else {
    echo "❌ Failed to change default language\n";
}

// Verify the change
$config_query = $db->query("SELECT * FROM oc_setting WHERE `key` = 'config_language'");
if ($config_query->num_rows) {
    echo "New default language: " . $config_query->row['value'] . "\n";
}

echo "\n=== TESTING BANNER DISPLAY ===\n";

// Test banner loading with Ukrainian as default
$code = 'uk'; // This should now be the default

if ($code == 'en') {
    $banner_id = 9;
    $banner_name = 'English';
} elseif ($code == 'uk') {
    $banner_id = 12;
    $banner_name = 'Ukrainian';
} else {
    $banner_id = 12; // Default to Ukrainian
    $banner_name = 'Ukrainian (default)';
}

echo "Selected banner: $banner_name (ID: $banner_id)\n";

// Load banner data
$banner_query = $db->query("SELECT * FROM oc_banner WHERE banner_id = $banner_id");
if ($banner_query->num_rows) {
    echo "Banner exists: " . $banner_query->row['name'] . "\n";
    
    $images_query = $db->query("SELECT * FROM oc_banner_image WHERE banner_id = $banner_id");
    echo "Images count: " . $images_query->num_rows . "\n";
    
    if ($images_query->num_rows > 0) {
        echo "✅ Banner should now be displayed!\n";
        foreach ($images_query->rows as $image) {
            echo "  - Image: " . $image['image'] . " | Link: " . $image['link'] . "\n";
        }
    } else {
        echo "❌ No images found for banner!\n";
    }
} else {
    echo "❌ Banner does not exist!\n";
}
?>
