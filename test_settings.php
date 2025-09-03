<?php
echo "<h1>OpenCart Settings Test</h1>";

// Load main config
require_once('config.php');
require_once(DIR_SYSTEM . 'startup.php');

// Create Registry
$registry = new Registry();
$loader = new Loader($registry);
$config = new Config();
$registry->set('config', $config);

// Create DB
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
$registry->set('db', $db);

echo "<p>✓ Basic setup completed</p>";

// Check settings
echo "<h2>Checking OpenCart Settings</h2>";

try {
    // Check config_store_id
    $query = $db->query('SELECT * FROM ' . DB_PREFIX . 'setting WHERE `key` = "config_store_id" AND store_id = 0');
    if ($query->num_rows > 0) {
        echo "<p>✓ config_store_id: " . $query->row['value'] . "</p>";
    } else {
        echo "<p style='color: orange;'>⚠ config_store_id not found</p>";
    }
    
    // Check config_language
    $query = $db->query('SELECT * FROM ' . DB_PREFIX . 'setting WHERE `key` = "config_language" AND store_id = 0');
    if ($query->num_rows > 0) {
        echo "<p>✓ config_language: " . $query->row['value'] . "</p>";
    } else {
        echo "<p style='color: orange;'>⚠ config_language not found</p>";
    }
    
    // Check config_url
    $query = $db->query('SELECT * FROM ' . DB_PREFIX . 'setting WHERE `key` = "config_url" AND store_id = 0');
    if ($query->num_rows > 0) {
        echo "<p>✓ config_url: " . $query->row['value'] . "</p>";
    } else {
        echo "<p style='color: orange;'>⚠ config_url not found</p>";
    }
    
    // Check if there are any language records
    $query = $db->query('SELECT * FROM ' . DB_PREFIX . 'language LIMIT 3');
    echo "<p>✓ Languages found: " . $query->num_rows . "</p>";
    foreach ($query->rows as $lang) {
        echo "<p>  - " . $lang['name'] . " (" . $lang['code'] . ")</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}

echo "<h2>Test Completed</h2>";
?>
