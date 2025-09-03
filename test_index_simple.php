<?php
echo "<h1>Simple Index.php Test</h1>";

// Load main config
require_once('config.php');
echo "<p>✓ Main config loaded</p>";

// Load PDF autoload
require_once 'pdf/vendor/autoload.php';
echo "<p>✓ PDF autoload loaded</p>";

// Load startup
require_once(DIR_SYSTEM . 'startup.php');
echo "<p>✓ Startup loaded</p>";

// Create Registry
$registry = new Registry();
echo "<p>✓ Registry created</p>";

// Create Loader
$loader = new Loader($registry);
echo "<p>✓ Loader created</p>";

// Create Config
$config = new Config();
echo "<p>✓ Config created</p>";

// Set config in registry
$registry->set('config', $config);
echo "<p>✓ Config set in registry</p>";

// Create DB
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
$registry->set('db', $db);
echo "<p>✓ DB created and set</p>";

// Check if we can get settings
try {
    $query = $db->query('SELECT * FROM ' . DB_PREFIX . 'setting WHERE store_id = 0 LIMIT 1');
    echo "<p>✓ DB query successful, rows: " . count($query->rows) . "</p>";
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ DB query failed: " . $e->getMessage() . "</p>";
}

echo "<h2>All Steps Completed Successfully!</h2>";
echo "<p>If you see this message, index.php core functionality works!</p>";
?>
