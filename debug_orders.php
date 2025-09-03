<?php
// Тестовый файл для анализа данных заказов
require_once('config.php');

try {
    $pdo = new PDO("mysql:host=" . DB_HOSTNAME . ";dbname=" . DB_DATABASE, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Запрос для получения заказов с пустыми полями
    $sql = "SELECT order_id, firstname, lastname, telephone, email, customer_id, order_status_id, total, date_added FROM " . DB_PREFIX . "order WHERE firstname = '' OR lastname = '' OR telephone = '' ORDER BY order_id DESC LIMIT 10";
    
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h2>Заказы с пустыми полями:</h2>";
    echo "<table border='1'>";
    echo "<tr><th>ID</th><th>Имя</th><th>Фамилия</th><th>Телефон</th><th>Email</th><th>Customer ID</th><th>Статус</th><th>Сумма</th><th>Дата</th></tr>";
    
    foreach ($results as $row) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['order_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['firstname']) . "</td>";
        echo "<td>" . htmlspecialchars($row['lastname']) . "</td>";
        echo "<td>" . htmlspecialchars($row['telephone']) . "</td>";
        echo "<td>" . htmlspecialchars($row['email']) . "</td>";
        echo "<td>" . htmlspecialchars($row['customer_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['order_status_id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['total']) . "</td>";
        echo "<td>" . htmlspecialchars($row['date_added']) . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
    // Проверим общее количество заказов
    $total_sql = "SELECT COUNT(*) as total FROM " . DB_PREFIX . "order";
    $total_stmt = $pdo->query($total_sql);
    $total = $total_stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "<h3>Общее количество заказов: " . $total['total'] . "</h3>";
    
    // Проверим заказы с customer_id = 0
    $guest_sql = "SELECT COUNT(*) as guest_count FROM " . DB_PREFIX . "order WHERE customer_id = 0";
    $guest_stmt = $pdo->query($guest_sql);
    $guest = $guest_stmt->fetch(PDO::FETCH_ASSOC);
    
    echo "<h3>Заказы без регистрации (customer_id = 0): " . $guest['guest_count'] . "</h3>";
    
} catch (PDOException $e) {
    echo "Ошибка подключения к базе данных: " . $e->getMessage();
}
?>
