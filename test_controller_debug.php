<?php
echo "<h1>Controller Debug Test</h1>";

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

// Try to create a simple front controller
echo "<h2>Testing Controller Creation</h2>";

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
                    
                    // Try to call index method with detailed error handling
                    try {
                        echo "<p>Calling index method...</p>";
                        
                        // Set error handler to catch all errors
                        set_error_handler(function($errno, $errstr, $errfile, $errline) {
                            echo "<p style='color: orange;'>⚠ Notice: $errstr in $errfile on line $errline</p>";
                            return true;
                        });
                        
                        // Set exception handler
                        set_exception_handler(function($e) {
                            echo "<p style='color: red;'>✗ Fatal Error: " . $e->getMessage() . "</p>";
                            echo "<p>File: " . $e->getFile() . " Line: " . $e->getLine() . "</p>";
                        });
                        
                        ob_start();
                        $home_controller->index();
                        $output = ob_get_clean();
                        
                        echo "<p>✓ Home controller index method executed successfully</p>";
                        echo "<p>Output length: " . strlen($output) . " characters</p>";
                        
                        // Show first 1000 characters of output
                        if (strlen($output) > 0) {
                            echo "<h3>Output Preview:</h3>";
                            echo "<div style='background: #f0f0f0; padding: 10px; border: 1px solid #ccc; max-height: 400px; overflow: auto;'>";
                            echo htmlspecialchars(substr($output, 0, 1000));
                            if (strlen($output) > 1000) {
                                echo "... [truncated]";
                            }
                            echo "</div>";
                        }
                        
                    } catch (Exception $e) {
                        echo "<p style='color: orange;'>⚠ Index method error: " . $e->getMessage() . "</p>";
                        echo "<p>Error details: " . $e->getTraceAsString() . "</p>";
                    } catch (Error $e) {
                        echo "<p style='color: red;'>✗ Fatal Error: " . $e->getMessage() . "</p>";
                        echo "<p>Error details: " . $e->getTraceAsString() . "</p>";
                    }
                } else {
                    echo "<p style='color: orange;'>⚠ Home controller index method not found</p>";
                }
                
            } catch (Exception $e) {
                echo "<p style='color: red;'>✗ Error creating controller: " . $e->getMessage() . "</p>";
            } catch (Error $e) {
                echo "<p style='color: red;'>✗ Fatal Error creating controller: " . $e->getMessage() . "</p>";
            }
        } else {
            echo "<p style='color: orange;'>⚠ Home controller class not found</p>";
        }
    } else {
        echo "<p style='color: red;'>✗ Home controller not found</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
} catch (Error $e) {
    echo "<p style='color: red;'>✗ Fatal Error: " . $e->getMessage() . "</p>";
}

echo "<h2>Test Completed</h2>";
?>
