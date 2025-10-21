<?php
// Удаляем условие для отображения кнопок
$file = 'catalog/view/theme/default/template/common/header.tpl';
$content = file_get_contents($file);

// Удаляем строку с условием и endif
$content = str_replace('        <?php if ( $language_code == \'uk\' || $language_code == \'en\' ): ?>', '', $content);
$content = str_replace('        <?php endif; ?>', '', $content);

file_put_contents($file, $content);

echo "Removed condition from header.tpl\n";
?>
