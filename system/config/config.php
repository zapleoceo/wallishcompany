<?php
// Version
define('VERSION', '2.3.0.2');

// Configuration
if (is_file(DIR_CONFIG . 'config.php')) {
    require_once(DIR_CONFIG . 'config.php');
}

// Startup
require_once(DIR_SYSTEM . 'startup.php');

// Registry
$registry = new Registry();

// Loader
$loader = new Loader($registry);
$registry->set('load', $loader);

// Config
$config = new Config();
$registry->set('config', $config);

// Database
$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);
$registry->set('db', $db);

// Settings
$query = $db->query('SELECT * FROM ' . DB_PREFIX . 'setting WHERE store_id = \'0\' OR store_id = \'' . (int)$config->get('config_store_id') . '\' ORDER BY store_id ASC');

foreach ($query->rows as $setting) {
    if (!$setting['serialized']) {
        $config->set($setting['key'], $setting['value']);
    } else {
        $config->set($setting['key'], unserialize($setting['value']));
    }
}

// URL
$url = new Url($config->get('config_secure') ? $config->get('config_ssl') : $config->get('config_url'));
$registry->set('url', $url);

// Log
$log = new Log($config->get('config_error_filename'));
$registry->set('log', $log);

// Error Handler
function error_handler($errno, $errstr, $errfile, $errline) {
    global $log, $config;

    switch ($errno) {
        case E_NOTICE:
        case E_USER_NOTICE:
            $error = 'Notice';
            break;
        case E_WARNING:
        case E_USER_WARNING:
            $error = 'Warning';
            break;
        case E_ERROR:
        case E_USER_ERROR:
            $error = 'Fatal Error';
            break;
        default:
            $error = 'Unknown';
            break;
    }

    if ($config->get('config_error_display')) {
        echo '<b>' . $error . '</b>: ' . $errstr . ' in <b>' . $errfile . '</b> on line <b>' . $errline . '</b>';
    }

    if ($config->get('config_error_log')) {
        $log->write('PHP ' . $error . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);
    }

    return true;
}

// Error Handler
set_error_handler('error_handler');

// Request
$request = new Request();
$registry->set('request', $request);

// Response
$response = new Response();
$response->addHeader('Content-Type: text/html; charset=utf-8');
$registry->set('response', $response);

// Cache
$cache = new Cache('file');
$registry->set('cache', $cache);

// Session
$session = new Session();
$registry->set('session', $session);

// Language
$languages = array();

$query = $db->query('SELECT * FROM ' . DB_PREFIX . 'language');

foreach ($query->rows as $result) {
    $languages[$result['code']] = $result;
}

$config->set('config_language_id', $languages[$config->get('config_language')]['language_id']);
$config->set('config_language', $languages[$config->get('config_language')]['directory']);
$config->set('config_language_admin', $languages[$config->get('config_admin_language')]['directory']);

// Document
$document = new Document();
$registry->set('document', $document);

// Event
$event = new Event($registry);
$registry->set('event', $event);

// Event Registry
$event->register('view/*/before', new Action('event/theme/override'));
$event->register('model/*/before', new Action('event/debug/before'));
$event->register('model/*/after', new Action('event/debug/after'));

// Loader
$loader->register('Action', new Action(''));
$loader->register('Event', new Event($registry));
$loader->register('User', new User($registry));
$loader->register('Model', new Model($registry));
$loader->register('Config', new Config());
$loader->register('Loader', new Loader($registry));
$loader->register('Request', new Request());
$loader->register('Response', new Response());
$loader->register('Url', new Url($config->get('config_secure') ? $config->get('config_ssl') : $config->get('config_url')));
$loader->register('Session', new Session());
$loader->register('Language', new Language($registry));
$loader->register('Document', new Document());
$loader->register('Cache', new Cache('file'));
$loader->register('Image', new Image($registry));
$loader->register('Currency', new Currency($registry));
$loader->register('Weight', new Weight($registry));
$loader->register('Length', new Length($registry));
$loader->register('Cart', new Cart($registry));
$loader->register('Customer', new Customer($registry));
$loader->register('CustomerGroup', new CustomerGroup($registry));
$loader->register('Affiliate', new Affiliate($registry));
$loader->register('Tax', new Tax($registry));
$loader->register('TaxRate', new TaxRate($registry));
$loader->register('TaxClass', new TaxClass($registry));
$loader->register('Product', new Product($registry));
$loader->register('Category', new Category($registry));
$loader->register('Manufacturer', new Manufacturer($registry));
$loader->register('Download', new Download($registry));
$loader->register('Order', new Order($registry));
$loader->register('OrderStatus', new OrderStatus($registry));
$loader->register('Return', new Return($registry));
$loader->register('ReturnAction', new ReturnAction($registry));
$loader->register('ReturnReason', new ReturnReason($registry));
$loader->register('ReturnStatus', new ReturnStatus($registry));
$loader->register('Voucher', new Voucher($registry));
$loader->register('VoucherTheme', new VoucherTheme($registry));
$loader->register('VoucherHistory', new VoucherHistory($registry));
$loader->register('Store', new Store($registry));
$loader->register('Settings', new Settings($registry));
$loader->register('Extension', new Extension($registry));
$loader->register('Mail', new Mail($registry));
$loader->register('Pagination', new Pagination($registry));
$loader->register('Openbay', new Openbay($registry));
?>
