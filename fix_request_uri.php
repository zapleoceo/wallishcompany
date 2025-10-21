<?php
// Исправляем условие для проверки REQUEST_URI
$file = 'catalog/view/theme/default/template/common/header.tpl';
$content = file_get_contents($file);

// Заменяем условие
$old = "\t<?php if ( \$_SERVER['REQUEST_URI'] == '/' || \$_SERVER['REQUEST_URI'] == '/en' || \$_SERVER['REQUEST_URI'] == '/uk' || \$_SERVER['REQUEST_URI'] == '/ru'): ?>";
$new = "\t<?php if ( \$_SERVER['REQUEST_URI'] == '/' || \$_SERVER['REQUEST_URI'] == '/en' || \$_SERVER['REQUEST_URI'] == '/uk' || \$_SERVER['REQUEST_URI'] == '/ru' || strpos(\$_SERVER['REQUEST_URI'], '/index.php?route=common/home') !== false ): ?>";

$content = str_replace($old, $new, $content);

file_put_contents($file, $content);

echo "Fixed REQUEST_URI condition in header.tpl\n";
?>
