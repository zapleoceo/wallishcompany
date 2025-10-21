<?php
// Временный файл для исправления header.php
$file = 'catalog/controller/common/header.php';
$content = file_get_contents($file);

// Найти строку с $data['top_block_link'] и добавить после неё
$pattern = '/(\$data\[\'top_block_link\'\]\s*=\s*\$this->url->link\(\'information\/information\', \'information_id=16\', true\);\s*)/';
$replacement = '$1' . "\n" . '                $data["language_code"] = $this->language->get("code");' . "\n";

$new_content = preg_replace($pattern, $replacement, $content);
file_put_contents($file, $new_content);

echo "Fixed header.php\n";
?>
