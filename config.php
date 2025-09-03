<?php
define('UKCOUNTRYID', 192);

define('STYLE_PATH', '/templ/');
define('CSSJS', '?t='.time());

// HTTP Image
define('HTTP_IMAGE', '/image/');

// Num links for Pagintation
define('NUM_LINKS', 4);

// HTTP
define('HTTP_SERVER', '/');

// HTTPS
define('HTTPS_SERVER', '/');

// DIR
define('DIR_APPLICATION',  dirname(__FILE__) . '/catalog/');
define('DIR_SYSTEM',       dirname(__FILE__) . '/system/');
define('DIR_LANGUAGE',     dirname(__FILE__) . '/catalog/language/');
define('DIR_TEMPLATE',     dirname(__FILE__) . '/catalog/view/theme/');
define('DIR_CONFIG',       dirname(__FILE__) . '/system/config/');
define('DIR_IMAGE',        dirname(__FILE__) . '/image/');
define('DIR_CACHE',        dirname(__FILE__) . '/system/storage/cache/');
define('DIR_DOWNLOAD',     dirname(__FILE__) . '/system/storage/download/');
define('DIR_LOGS'        , dirname(__FILE__) . '/system/storage/logs/');
define('DIR_MODIFICATION', dirname(__FILE__) . '/system/storage/modification/');
define('DIR_UPLOAD'      , dirname(__FILE__) . '/system/storage/upload/');

// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'holidaydecor_usr');
define('DB_PASSWORD', 'fYoF4TVu9ukhjFnC');
define('DB_DATABASE', 'holidaydecor__db');
define('DB_PORT', '3306');
define('DB_PREFIX', 'oc_');
?>
