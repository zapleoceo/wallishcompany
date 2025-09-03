<?php
echo "<h1>Full Index.php Load Test</h1>";

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

// Now simulate the full index.php initialization
echo "<h2>Initializing OpenCart Objects</h2>";

try {
    // Store
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

    // Settings
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

    echo "<p>✓ Store and settings initialized</p>";

    // Url
    $url = new Url($config->get('config_url'), $config->get('config_secure') ? $config->get('config_ssl') : $config->get('config_url'));
    $registry->set('url', $url);

    // Log
    $log = new Log($config->get('config_error_filename'));
    $registry->set('log', $log);

    // Request
    $request = new Request();
    $registry->set('request', $request);

    // Response
    $response = new Response();
    $response->addHeader('Content-Type: text/html; charset=utf-8');
    $response->setCompression($config->get('config_compression'));
    $registry->set('response', $response);

    // Cache
    $cache = new Cache('file');
    $registry->set('cache', $cache);

    // Session
    $session = new Session();
    $registry->set('session', $session);

    // Language Detection
    $languages = array();
    $query = $db->query("SELECT * FROM `" . DB_PREFIX . "language` WHERE status = '1'");
    foreach ($query->rows as $result) {
        $languages[$result['code']] = $result;
    }

    if (isset($session->data['language']) && array_key_exists($session->data['language'], $languages)) {
        $code = $session->data['language'];
    } elseif (isset($request->cookie['language']) && array_key_exists($request->cookie['language'], $languages)) {
        $code = $request->cookie['language'];
    } else {
        $code = $config->get('config_language');
    }

    if (!isset($session->data['language']) || $session->data['language'] != $code) {
        $session->data['language'] = $code;
    }

    $config->set('config_language_id', $languages[$code]['language_id']);
    $config->set('config_language', $languages[$code]['code']);

    // Language
    $language = new Language($languages[$code]['directory']);
    $language->load($languages[$code]['directory']);
    $registry->set('language', $language);

    // Document
    $registry->set('document', new Document());

    // Customer
    $customer = new Customer($registry);
    $registry->set('customer', $customer);

    // Customer Group
    if ($customer->isLogged()) {
        $config->set('config_customer_group_id', $customer->getGroupId());
    } elseif (isset($session->data['customer']) && isset($session->data['customer']['customer_group_id'])) {
        $config->set('config_customer_group_id', $session->data['customer']['customer_group_id']);
    } elseif (isset($session->data['guest']) && isset($session->data['guest']['customer_group_id'])) {
        $config->set('config_customer_group_id', $session->data['guest']['customer_group_id']);
    }

    // Affiliate
    $registry->set('affiliate', new Affiliate($registry));

    // Currency
    $registry->set('currency', new Currency($registry));

    // Tax
    $registry->set('tax', new Tax($registry));

    // Weight
    $registry->set('weight', new Weight($registry));

    // Length
    $registry->set('length', new Length($registry));

    // Cart
    $registry->set('cart', new Cart($registry));

    // Encryption
    $registry->set('encryption', new Encryption($config->get('config_encryption')));

    // OpenBay Pro
    $registry->set('openbay', new Openbay($registry));

    // Event
    $event = new Event($registry);
    $registry->set('event', $event);

    $query = $db->query("SELECT * FROM " . DB_PREFIX . "event");
    foreach ($query->rows as $result) {
        $event->register($result['trigger'], $result['action']);
    }

    echo "<p>✓ All OpenCart objects initialized</p>";

    // Now check what's in registry
    echo "<h2>Checking Registry Contents</h2>";
    
    $objects = ['config', 'db', 'load', 'url', 'log', 'request', 'response', 'cache', 'session', 'language', 'customer', 'affiliate', 'currency', 'tax', 'weight', 'length', 'cart', 'encryption', 'openbay', 'event', 'document'];
    
    foreach ($objects as $object_name) {
        $obj = $registry->get($object_name);
        if ($obj) {
            echo "<p>✓ {$object_name}: " . get_class($obj) . "</p>";
        } else {
            echo "<p style='color: orange;'>⚠ {$object_name}: NOT found</p>";
        }
    }

    // Try to create controller now
    echo "<h2>Testing Controller Creation</h2>";
    
    try {
        $controller_path = DIR_APPLICATION . 'controller/common/home.php';
        if (file_exists($controller_path)) {
            echo "<p>✓ Home controller exists</p>";
            
            require_once($controller_path);
            if (class_exists('ControllerCommonHome')) {
                echo "<p>✓ Home controller class loaded</p>";
                
                try {
                    $home_controller = new ControllerCommonHome($registry);
                    echo "<p>✓ Home controller instance created</p>";
                    
                    if (method_exists($home_controller, 'index')) {
                        echo "<p>✓ Home controller index method exists</p>";
                        
                        try {
                            echo "<p>Calling index method...</p>";
                            ob_start();
                            $home_controller->index();
                            $output = ob_get_clean();
                            
                            echo "<p>✓ Home controller index method executed successfully</p>";
                            echo "<p>Output length: " . strlen($output) . " characters</p>";
                            
                        } catch (Exception $e) {
                            echo "<p style='color: orange;'>⚠ Index method error: " . $e->getMessage() . "</p>";
                        } catch (Error $e) {
                            echo "<p style='color: red;'>✗ Fatal Error: " . $e->getMessage() . "</p>";
                        }
                    }
                } catch (Exception $e) {
                    echo "<p style='color: red;'>✗ Error creating controller: " . $e->getMessage() . "</p>";
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
