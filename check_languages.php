<?php
require_once 'config.php';
require_once 'system/startup.php';

$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
$query = $db->query("SELECT * FROM oc_language WHERE status = 1");

echo "Active languages:\n";
foreach($query->rows as $row) {
    echo $row['code'] . ' - ' . $row['name'] . ' (status: ' . $row['status'] . ')' . "\n";
}

echo "\nAll languages:\n";
$query = $db->query("SELECT * FROM oc_language");
foreach($query->rows as $row) {
    echo $row['code'] . ' - ' . $row['name'] . ' (status: ' . $row['status'] . ')' . "\n";
}
?>
