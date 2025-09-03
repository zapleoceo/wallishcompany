<?php
define('STYLE_PATH', '/templ/');
define('CSSJS', '?v='.time());
define('UKCOUNTRYID', 192);

// HTTP Image
define('HTTP_IMAGE', '/image/');

// HTTP
define('HTTP_SERVER', '/admin/');
define('HTTP_CATALOG', '/');

// HTTPS
define('HTTPS_SERVER', '/admin/');
define('HTTPS_CATALOG', '/');

// DIR
define('DIR_APPLICATION',  dirname(__FILE__) . '/');
define('DIR_SYSTEM',       dirname(__FILE__) . '/../system/');
define('DIR_LANGUAGE',     dirname(__FILE__) . '/language/');
define('DIR_TEMPLATE',     dirname(__FILE__) . '/view/template/');
define('DIR_CONFIG',       dirname(__FILE__) . '/../system/config/');
define('DIR_IMAGE',        dirname(__FILE__) . '/../image/');
define('DIR_CACHE',        dirname(__FILE__) . '/../system/storage/cache/');
define('DIR_DOWNLOAD',     dirname(__FILE__) . '/../system/storage/download/');
define('DIR_LOGS',         dirname(__FILE__) . '/../system/storage/logs/');
define('DIR_MODIFICATION', dirname(__FILE__) . '/../system/storage/modification/');
define('DIR_UPLOAD',       dirname(__FILE__) . '/../system/storage/upload/');
define('DIR_CATALOG',      dirname(__FILE__) . '/../catalog/');

// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'holidaydecor_usr');
define('DB_PASSWORD', 'fYoF4TVu9ukhjFnC');
define('DB_DATABASE', 'holidaydecor__db');
define('DB_PORT', '3306');
define('DB_PREFIX', 'oc_');
?>