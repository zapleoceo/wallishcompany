<?php
echo "<h1>Registry Debug Test</h1>";

// Simulate request
$_GET['route'] = 'common/home';
$_SERVER['HTTP_HOST'] = 'wallishcompany.com';
$_SERVER['REQUEST_URI'] = '/index.php?route=common/home';

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

// Check what's in registry
echo "<h2>Checking Registry Contents</h2>";

try {
    // Check if document is set
    $document = $registry->get('document');
    if ($document) {
        echo "<p>✓ Document found in registry</p>";
        echo "<p>Document class: " . get_class($document) . "</p>";
    } else {
        echo "<p style='color: red;'>✗ Document NOT found in registry</p>";
    }
    
    // Check if other objects are set
    $objects = ['config', 'db', 'load', 'url', 'log', 'request', 'response', 'cache', 'session', 'language', 'customer', 'affiliate', 'currency', 'tax', 'weight', 'length', 'cart', 'encryption', 'openbay', 'event'];
    
    foreach ($objects as $object_name) {
        $obj = $registry->get($object_name);
        if ($obj) {
            echo "<p>✓ {$object_name}: " . get_class($obj) . "</p>";
        } else {
            echo "<p style='color: orange;'>⚠ {$object_name}: NOT found</p>";
        }
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}

echo "<h2>Test Completed</h2>";
?>
