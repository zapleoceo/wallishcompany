<?php
echo "<h1>Direct Index.php Load Test</h1>";

// Simulate request
$_GET['route'] = '';
$_SERVER['HTTP_HOST'] = 'wallishcompany.com';
$_SERVER['REQUEST_URI'] = '/index.php';

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

// Check if we can get settings
try {
    $query = $db->query('SELECT * FROM ' . DB_PREFIX . 'setting WHERE `key` IN ("config_store_id", "config_url", "config_ssl") AND store_id = 0');
    echo "<p>✓ Critical settings found: " . count($query->rows) . "</p>";
    
    foreach ($query->rows as $row) {
        echo "<p>  - {$row['key']}: {$row['value']}</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}

// Try to create a simple front controller
echo "<h2>Testing Front Controller</h2>";

try {
    // Check if common/home controller exists
    $controller_path = DIR_APPLICATION . 'controller/common/home.php';
    if (file_exists($controller_path)) {
        echo "<p>✓ Home controller exists: " . $controller_path . "</p>";
        
        // Try to load it
        require_once($controller_path);
        if (class_exists('ControllerCommonHome')) {
            echo "<p>✓ Home controller class loaded</p>";
            
            // Try to create instance
            try {
                $home_controller = new ControllerCommonHome($registry);
                echo "<p>✓ Home controller instance created</p>";
                
                // Check if index method exists
                if (method_exists($home_controller, 'index')) {
                    echo "<p>✓ Home controller index method exists</p>";
                    
                    // Try to call index method
                    try {
                        ob_start();
                        $home_controller->index();
                        $output = ob_get_clean();
                        echo "<p>✓ Home controller index method executed</p>";
                        echo "<p>Output length: " . strlen($output) . " characters</p>";
                        
                    } catch (Exception $e) {
                        echo "<p style='color: orange;'>⚠ Index method error: " . $e->getMessage() . "</p>";
                    }
                } else {
                    echo "<p style='color: orange;'>⚠ Home controller index method not found</p>";
                }
                
            } catch (Exception $e) {
                echo "<p style='color: red;'>✗ Error creating controller: " . $e->getMessage() . "</p>";
            }
        } else {
            echo "<p style='color: orange;'>⚠ Home controller class not found</p>";
        }
    } else {
        echo "<p style='color: red;'>✗ Home controller not found</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}

echo "<h2>Test Completed</h2>";
?>
