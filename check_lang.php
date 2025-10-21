<?php
require_once 'config.php';
require_once 'system/startup.php';

$registry = new Registry();
$language = $registry->get('language');
$code = $language->get('code');

echo "Language code: " . $code . "\n";
echo "Is uk: " . ($code == 'uk' ? 'YES' : 'NO') . "\n";
?>
