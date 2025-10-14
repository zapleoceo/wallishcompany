<?php
require_once 'config.php';
require_once 'system/startup.php';

$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);

echo "=== DEBUG BANNER DATA ===\n";

// Check banner data for different languages
$banner_ids = [7, 9, 12]; // Russian, English, Ukrainian
$banner_names = ['Russian', 'English', 'Ukrainian'];

foreach ($banner_ids as $index => $banner_id) {
    echo "\n--- " . $banner_names[$index] . " Banner (ID: $banner_id) ---\n";
    
    // Check if banner exists
    $banner_query = $db->query("SELECT * FROM oc_banner WHERE banner_id = $banner_id");
    if ($banner_query->num_rows) {
        echo "Banner exists: " . $banner_query->row['name'] . " (status: " . $banner_query->row['status'] . ")\n";
        
        // Check banner images
        $images_query = $db->query("SELECT * FROM oc_banner_image WHERE banner_id = $banner_id");
        echo "Images count: " . $images_query->num_rows . "\n";
        
        foreach ($images_query->rows as $image) {
            echo "  - Image: " . $image['image'] . " | Link: " . $image['link'] . "\n";
        }
    } else {
        echo "Banner does not exist!\n";
    }
}

// Check current language
echo "\n--- Current Language Check ---\n";
$lang_query = $db->query("SELECT * FROM oc_language WHERE status = 1");
foreach ($lang_query->rows as $lang) {
    echo "Active language: " . $lang['code'] . " - " . $lang['name'] . "\n";
}
?>
