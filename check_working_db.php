<?php
echo "<h1>Проверка рабочей версии БД</h1>";

// Конфигурация рабочей БД (если есть)
$db_config = [
    'hostname' => 'localhost',
    'username' => 'holidaydecor_usr', 
    'password' => 'fYoF4TVu9ukhjFnC',
    'database' => 'holidaydecor__db',
    'port' => '3306',
    'prefix' => 'oc_'
];

try {
    $pdo = new PDO(
        "mysql:host={$db_config['hostname']};dbname={$db_config['database']};port={$db_config['port']};charset=utf8",
        $db_config['username'],
        $db_config['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    echo "<p>✓ Подключение к БД успешно</p>";
    
    // Проверяем критические настройки
    $critical_settings = [
        'config_store_id',
        'config_url', 
        'config_ssl',
        'config_language',
        'config_name'
    ];
    
    echo "<h2>Критические настройки:</h2>";
    
    foreach ($critical_settings as $setting) {
        $stmt = $pdo->prepare("SELECT * FROM oc_setting WHERE `key` = ? AND store_id = 0");
        $stmt->execute([$setting]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($row) {
            echo "<p style='color: green;'>✅ {$setting}: {$row['value']}</p>";
        } else {
            echo "<p style='color: red;'>❌ {$setting}: НЕ НАЙДЕН</p>";
        }
    }
    
    // Проверяем общее количество настроек
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM oc_setting WHERE store_id = 0");
    $total = $stmt->fetch()['total'];
    echo "<p>📊 Всего настроек: {$total}</p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>✗ Ошибка: " . $e->getMessage() . "</p>";
}

echo "<h2>Проверка завершена</h2>";
?>
