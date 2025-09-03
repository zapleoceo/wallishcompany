<?php
// Простой тест подключения к БД
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Тест подключения к БД...\n";

// Подключаемся к БД
$db = new mysqli('localhost', 'holidaydecor_usr', 'fYoF4TVu9ukhjFnC', 'holidaydecor__db', 3306);

if ($db->connect_error) {
    die("Ошибка подключения: " . $db->connect_error);
}

echo "Подключение к БД успешно!\n";

// Проверяем таблицы
$result = $db->query("SHOW TABLES LIKE 'oc_setting'");
if ($result && $result->num_rows > 0) {
    echo "Таблица oc_setting найдена\n";
    
    // Проверяем настройки
    $settings = $db->query("SELECT * FROM oc_setting WHERE store_id = 0 LIMIT 5");
    if ($settings) {
        echo "Найдено настроек: " . $settings->num_rows . "\n";
        while ($row = $settings->fetch_assoc()) {
            echo "- " . $row['key'] . ": " . substr($row['value'], 0, 50) . "...\n";
        }
    }
} else {
    echo "Таблица oc_setting НЕ найдена!\n";
}

$db->close();
echo "Тест завершен\n";
?>
