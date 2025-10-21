<?php
// Временный файл для отладки header.tpl
$file = 'catalog/view/theme/default/template/common/header.tpl';
$content = file_get_contents($file);

// Заменить строку 826 на отладочную информацию
$lines = explode("\n", $content);
$lines[825] = '        <?php echo "<!-- Debug: lang = " . $lang . " -->"; ?>';

$new_content = implode("\n", $lines);
file_put_contents($file, $new_content);

echo "Updated header.tpl with lang debug info\n";
?>
