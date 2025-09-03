<?php
echo "<h1>Step by Step Controller Test</h1>";

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

    // Now test controller step by step
    echo "<h2>Testing Controller Step by Step</h2>";
    
    try {
        $controller_path = DIR_APPLICATION . 'controller/common/home.php';
        if (file_exists($controller_path)) {
            require_once($controller_path);
            if (class_exists('ControllerCommonHome')) {
                $home_controller = new ControllerCommonHome($registry);
                
                echo "<p>✓ Controller created</p>";
                
                // Test step 1: document methods
                echo "<h3>Step 1: Testing Document Methods</h3>";
                try {
                    $home_controller->document->setTitle($home_controller->config->get('config_meta_title'));
                    echo "<p>✓ setTitle executed</p>";
                    
                    $home_controller->document->setDescription($home_controller->config->get('config_meta_description'));
                    echo "<p>✓ setDescription executed</p>";
                    
                    $home_controller->document->setKeywords($home_controller->config->get('config_meta_keyword'));
                    echo "<p>✓ setKeywords executed</p>";
                    
                } catch (Exception $e) {
                    echo "<p style='color: red;'>✗ Document error: " . $e->getMessage() . "</p>";
                }
                
                // Test step 2: language loading
                echo "<h3>Step 2: Testing Language Loading</h3>";
                try {
                    $home_controller->load->language('common/home');
                    echo "<p>✓ Language loaded</p>";
                    
                    $data = array();
                    $data['text_view_other_big'] = $home_controller->language->get('text_view_other_big');
                    $data['text_go_catalog_big'] = $home_controller->language->get('text_go_catalog_big');
                    $data['text_view_other'] = $home_controller->language->get('text_view_other');
                    $data['text_view_product_category'] = $home_controller->language->get('text_view_product_category');
                    
                    echo "<p>✓ Language variables loaded</p>";
                    
                } catch (Exception $e) {
                    echo "<p style='color: red;'>✗ Language error: " . $e->getMessage() . "</p>";
                }
                
                // Test step 3: template loading
                echo "<h3>Step 3: Testing Template Loading</h3>";
                try {
                    $template_output = $home_controller->load->view('default/template/common/home', $data);
                    echo "<p>✓ Template loaded</p>";
                    echo "<p>Template output length: " . strlen($template_output) . " characters</p>";
                    
                    if (strlen($template_output) > 0) {
                        echo "<h4>Template Output Preview:</h4>";
                        echo "<div style='background: #f0f0f0; padding: 10px; border: 1px solid #ccc; max-height: 300px; overflow: auto;'>";
                        echo htmlspecialchars(substr($template_output, 0, 500));
                        if (strlen($template_output) > 500) {
                            echo "... [truncated]";
                        }
                        echo "</div>";
                    }
                    
                } catch (Exception $e) {
                    echo "<p style='color: red;'>✗ Template error: " . $e->getMessage() . "</p>";
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
