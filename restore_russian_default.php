<?php
// Восстановление русского языка по умолчанию
$host = 'localhost';
$username = 'holidaydecor_usr';
$password = 'fYoF4TVu9ukhjFnC';
$database = 'holidaydecor__db';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Устанавливаем русский язык как активный и по умолчанию
    $sql = "UPDATE oc_language SET status = 1, sort_order = 1 WHERE language_id = 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    // Устанавливаем украинский как неактивный
    $sql = "UPDATE oc_language SET status = 0, sort_order = 2 WHERE language_id = 2";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    
    echo "Русский язык восстановлен как язык по умолчанию\n";
    
    // Проверяем результат
    $sql = "SELECT language_id, name, code, status, sort_order FROM oc_language ORDER BY sort_order";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $languages = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Текущие языки:\n";
    foreach ($languages as $lang) {
        echo "ID: {$lang['language_id']}, Name: {$lang['name']}, Code: {$lang['code']}, Status: {$lang['status']}, Sort: {$lang['sort_order']}\n";
    }
    
} catch(PDOException $e) {
    echo "Ошибка: " . $e->getMessage() . "\n";
}
?>
