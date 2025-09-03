<?php
echo "<h1>Template Load Test</h1>";

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
$registry->set('load', $loader);
$config = new Config();
$registry->set('config', $config);

// Create DB
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
$registry->set('db', $db);

echo "<p>✓ Basic setup completed</p>";

// Initialize OpenCart objects
try {
    // Store and settings
    if (isset($_SERVER['HTTPS']) && (($_SERVER['HTTPS'] == 'on') || ($_SERVER['HTTPS'] == '1'))) {
        $store_query = $db->query("SELECT * FROM " . DB_PREFIX . "store WHERE REPLACE(`ssl`, 'www.', '') = '" . $db->escape('https://' . str_replace('www.', '', $_SERVER['HTTP_HOST']) . rtrim(dirname($_SERVER['PHP_SELF']), '/.\\') . '/') . "'");
    } else {
        $store_query = $db->query("SELECT * FROM " . DB_PREFIX . "store WHERE REPLACE(`url`, 'www.', '') = '" . $db->escape('http://' . str_replace('www.', '', $_SERVER['HTTP_HOST']) . rtrim(dirname($_SERVER['PHP_SELF']), '/.\\') . '/') . "'");
    }

    if ($store_query->num_rows) {
        $config->set('config_store_id', $store_query->row['store_id']);
    } else {
        $config->set('config_store_id', 0);
    }

    $query = $db->query("SELECT * FROM `" . DB_PREFIX . "setting` WHERE store_id = '0' OR store_id = '" . (int)$config->get('config_store_id') . "' ORDER BY store_id ASC");
    foreach ($query->rows as $result) {
        if (!$result['serialized']) {
            $config->set($result['key'], $result['value']);
        } else {
            $config->set($result['key'], json_decode($result['value'], true));
        }
    }

    if (!$store_query->num_rows) {
        $config->set('config_url', HTTP_SERVER);
        $config->set('config_ssl', HTTPS_SERVER);
    }

    // Other objects
    $url = new Url($config->get('config_url'), $config->get('config_secure') ? $config->get('config_ssl') : $config->get('config_url'));
    $registry->set('url', $url);

    $log = new Log($config->get('config_error_filename'));
    $registry->set('log', $log);

    $request = new Request();
    $registry->set('request', $request);

    $response = new Response();
    $response->addHeader('Content-Type: text/html; charset=utf-8');
    $response->setCompression($config->get('config_compression'));
    $registry->set('response', $response);

    $cache = new Cache('file');
    $registry->set('cache', $cache);

    $session = new Session();
    $registry->set('session', $session);

    // Language
    $languages = array();
    $query = $db->query("SELECT * FROM `" . DB_PREFIX . "language` WHERE status = '1'");
    foreach ($query->rows as $result) {
        $languages[$result['code']] = $result;
    }

    $code = $config->get('config_language');
    if (!isset($session->data['language']) || $session->data['language'] != $code) {
        $session->data['language'] = $code;
    }

    $config->set('config_language_id', $languages[$code]['language_id']);
    $config->set('config_language', $languages[$code]['code']);

    $language = new Language($languages[$code]['directory']);
    $language->load($languages[$code]['directory']);
    $registry->set('language', $language);

    // Document
    $registry->set('document', new Document());

    // Customer
    $customer = new Customer($registry);
    $registry->set('customer', $customer);

    // Other objects
    $registry->set('affiliate', new Affiliate($registry));
    $registry->set('currency', new Currency($registry));
    $registry->set('tax', new Tax($registry));
    $registry->set('weight', new Weight($registry));
    $registry->set('length', new Length($registry));
    $registry->set('cart', new Cart($registry));
    $registry->set('encryption', new Encryption($config->get('config_encryption')));
    $registry->set('openbay', new Openbay($registry));
    $registry->set('event', new Event($registry));

    echo "<p>✓ All OpenCart objects initialized</p>";

    // Check template path
    echo "<h2>Checking Template Path</h2>";
    
    $template_path = DIR_TEMPLATE . $config->get('config_template') . '/template/common/home.tpl';
    echo "<p>Template path: " . $template_path . "</p>";
    
    if (file_exists($template_path)) {
        echo "<p>✓ Template exists</p>";
    } else {
        echo "<p style='color: red;'>✗ Template not found</p>";
        
        // Check default template
        $default_template = DIR_TEMPLATE . 'default/template/common/home.tpl';
        echo "<p>Default template path: " . $default_template . "</p>";
        
        if (file_exists($default_template)) {
            echo "<p>✓ Default template exists</p>";
        } else {
            echo "<p style='color: red;'>✗ Default template not found</p>";
        }
    }

    // Check config_template setting
    echo "<h2>Checking Template Configuration</h2>";
    $config_template = $config->get('config_template');
    echo "<p>config_template: " . ($config_template ? $config_template : 'NOT SET') . "</p>";

    // Try to create controller and check template loading
    echo "<h2>Testing Template Loading</h2>";
    
    try {
        $controller_path = DIR_APPLICATION . 'controller/common/home.php';
        if (file_exists($controller_path)) {
            require_once($controller_path);
            if (class_exists('ControllerCommonHome')) {
                $home_controller = new ControllerCommonHome($registry);
                
                if (method_exists($home_controller, 'index')) {
                    echo "<p>Calling index method...</p>";
                    
                    ob_start();
                    $home_controller->index();
                    $output = ob_get_clean();
                    
                    echo "<p>✓ Controller executed</p>";
                    echo "<p>Output length: " . strlen($output) . " characters</p>";
                    
                    if (strlen($output) > 0) {
                        echo "<h3>Output Preview:</h3>";
                        echo "<div style='background: #f0f0f0; padding: 10px; border: 1px solid #ccc; max-height: 400px; overflow: auto;'>";
                        echo htmlspecialchars(substr($output, 0, 1000));
                        if (strlen($output) > 1000) {
                            echo "... [truncated]";
                        }
                        echo "</div>";
                    } else {
                        echo "<p style='color: orange;'>⚠ No output generated</p>";
                    }
                }
            }
        }
    } catch (Exception $e) {
        echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Error: " . $e->getMessage() . "</p>";
}

echo "<h2>Test Completed</h2>";
?>
