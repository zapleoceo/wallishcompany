<?php
require_once 'config.php';
require_once 'system/startup.php';

$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);

// Update Ukrainian banner link
$result = $db->query("UPDATE oc_banner_image SET link = 'https://wallishcompany.com/katalog/?new=1&limit=500' WHERE banner_id = 12");

if ($result) {
    echo "Ukrainian banner link updated successfully!\n";
} else {
    echo "Error updating Ukrainian banner link.\n";
}

// Check the updated link
$query = $db->query("SELECT * FROM oc_banner_image WHERE banner_id = 12");
foreach($query->rows as $row) {
    echo "Banner ID 12 - Link: " . $row['link'] . "\n";
}
?>
