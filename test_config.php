<?php
require_once 'config.php';
require_once 'system/startup.php';
echo "Config class exists: " . (class_exists('Config') ? 'YES' : 'NO') . PHP_EOL;
echo "DIR_SYSTEM: " . (defined('DIR_SYSTEM') ? DIR_SYSTEM : 'NOT DEFINED') . PHP_EOL;
?>
