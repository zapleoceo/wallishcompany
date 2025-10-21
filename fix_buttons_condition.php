<?php
// Исправляем условие для отображения кнопок
$file = 'catalog/view/theme/default/template/common/header.tpl';
$content = file_get_contents($file);

// Заменяем условие
$old = "        <?php if ( \$language_code == 'uk' ): ?>";
$new = "        <?php if ( \$language_code == 'uk' || \$language_code == 'en' ): ?>";

$content = str_replace($old, $new, $content);

file_put_contents($file, $content);

echo "Fixed button condition in header.tpl\n";
?>
