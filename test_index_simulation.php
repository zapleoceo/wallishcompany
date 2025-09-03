<?php
echo "<h1>Index.php Simulation Test</h1>";

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
    $query = $db->query('SELECT * FROM ' . DB_PREFIX . 'setting WHERE `key` IN ("config_store_id", "config_url", "config_ssl", "config_seo_url") AND store_id = 0');
    echo "<p>✓ Critical settings found: " . count($query->rows) . "</p>";
    
    foreach ($query->rows as $row) {
        echo "<p>  - {$row['key']}: {$row['value']}</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}

// Try to simulate OpenCart routing logic
echo "<h2>Testing OpenCart Routing</h2>";

try {
    // Check if route is empty and set default
    $route = isset($_GET['route']) ? $_GET['route'] : '';
    echo "<p>Route: '" . htmlspecialchars($route) . "'</p>";
    
    if (empty($route)) {
        echo "<p>Route is empty, setting default to 'common/home'</p>";
        $route = 'common/home';
    }
    
    // Parse route
    $parts = explode('/', $route);
    echo "<p>Route parts: " . implode(', ', $parts) . "</p>";
    
    if (count($parts) >= 2) {
        $controller_path = DIR_APPLICATION . 'controller/' . $parts[0] . '/' . $parts[1] . '.php';
        echo "<p>Controller path: " . $controller_path . "</p>";
        
        if (file_exists($controller_path)) {
            echo "<p>✓ Controller exists</p>";
            
            // Try to load it
            require_once($controller_path);
            $class_name = 'Controller' . ucfirst($parts[0]) . ucfirst($parts[1]);
            echo "<p>Class name: " . $class_name . "</p>";
            
            if (class_exists($class_name)) {
                echo "<p>✓ Controller class loaded</p>";
                
                // Try to create instance
                try {
                    $controller = new $class_name($registry);
                    echo "<p>✓ Controller instance created</p>";
                    
                    // Check if index method exists
                    if (method_exists($controller, 'index')) {
                        echo "<p>✓ Controller index method exists</p>";
                        
                        // Try to call index method with error handling
                        try {
                            echo "<p>Calling index method...</p>";
                            ob_start();
                            $controller->index();
                            $output = ob_get_clean();
                            echo "<p>✓ Controller index method executed successfully</p>";
                            echo "<p>Output length: " . strlen($output) . " characters</p>";
                            
                        } catch (Exception $e) {
                            echo "<p style='color: orange;'>⚠ Index method error: " . $e->getMessage() . "</p>";
                            echo "<p>Error details: " . $e->getTraceAsString() . "</p>";
                        }
                    } else {
                        echo "<p style='color: orange;'>⚠ Controller index method not found</p>";
                    }
                    
                } catch (Exception $e) {
                    echo "<p style='color: red;'>✗ Error creating controller: " . $e->getMessage() . "</p>";
                }
            } else {
                echo "<p style='color: orange;'>⚠ Controller class not found</p>";
            }
        } else {
            echo "<p style='color: red;'>✗ Controller not found</p>";
        }
    } else {
        echo "<p style='color: orange;'>⚠ Invalid route format</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}

echo "<h2>Test Completed</h2>";
?>
