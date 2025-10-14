<?php
require_once 'config.php';
require_once 'system/startup.php';

$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);

echo "=== LANGUAGE DEBUG ===\n";

// Check default language setting
$config_query = $db->query("SELECT * FROM oc_setting WHERE `key` = 'config_language'");
if ($config_query->num_rows) {
    echo "Default language setting: " . $config_query->row['value'] . "\n";
} else {
    echo "No default language setting found\n";
}

// Check what language is being used
$languages = array();
$query = $db->query("SELECT * FROM oc_language WHERE status = '1'");
foreach ($query->rows as $result) {
    $languages[$result['code']] = $result;
}

echo "\nActive languages:\n";
foreach ($languages as $code => $lang) {
    echo "- $code: " . $lang['name'] . " (ID: " . $lang['language_id'] . ")\n";
}

// Simulate the language detection logic
$code = 'uk'; // Default to Ukrainian since Russian is disabled
echo "\nSimulated language code: $code\n";

if (isset($languages[$code])) {
    echo "Language found: " . $languages[$code]['name'] . "\n";
} else {
    echo "Language not found!\n";
}

// Test banner loading
echo "\n=== BANNER LOADING TEST ===\n";

// Simulate the banner loading logic
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
        echo "Banner should be displayed!\n";
        foreach ($images_query->rows as $image) {
            echo "  - Image: " . $image['image'] . " | Link: " . $image['link'] . "\n";
        }
    } else {
        echo "No images found for banner!\n";
    }
} else {
    echo "Banner does not exist!\n";
}
?>
