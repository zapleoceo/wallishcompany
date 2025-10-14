<?php
require_once 'config.php';
require_once 'system/startup.php';

$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);

echo "Banner groups:\n";
$query = $db->query("SELECT * FROM oc_banner WHERE status = 1");
foreach($query->rows as $row) {
    echo "Banner ID: " . $row['banner_id'] . " - Name: " . $row['name'] . " (status: " . $row['status'] . ")\n";
}

echo "\nBanner images for each group:\n";
$query = $db->query("SELECT * FROM oc_banner WHERE status = 1");
foreach($query->rows as $banner) {
    echo "\nBanner Group " . $banner['banner_id'] . " (" . $banner['name'] . "):\n";
    $images_query = $db->query("SELECT * FROM oc_banner_image WHERE banner_id = " . $banner['banner_id']);
    foreach($images_query->rows as $image) {
        echo "  - Image: " . $image['image'] . " | Link: " . $image['link'] . " | Title: " . $image['title'] . "\n";
    }
}
?>
