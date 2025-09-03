<?php
// API для работы с базой данных OpenCart
header('Content-Type: application/json; charset=utf-8');

// Конфигурация БД
$db_config = [
    'hostname' => 'localhost',
    'username' => 'holidaydecor_usr',
    'password' => 'fYoF4TVu9ukhjFnC',
    'database' => 'holidaydecor__db',
    'port' => '3306',
    'prefix' => 'oc_'
];

// Простая аутентификация
$valid_token = 'wallish_debug_2025';
$token = $_GET['token'] ?? '';

if ($token !== $valid_token) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized'], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $pdo = new PDO(
        "mysql:host={$db_config['hostname']};dbname={$db_config['database']};port={$db_config['port']};charset=utf8",
        $db_config['username'],
        $db_config['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    
    $action = $_GET['action'] ?? '';
    
    switch ($action) {
        case 'query':
            $sql = $_GET['sql'] ?? '';
            if (empty($sql)) {
                throw new Exception('SQL query is required');
            }
            
            $stmt = $pdo->query($sql);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo json_encode([
                'success' => true,
                'rows' => $rows,
                'count' => count($rows)
            ], JSON_UNESCAPED_UNICODE);
            break;
            
        case 'execute':
            $sql = $_GET['sql'] ?? '';
            if (empty($sql)) {
                throw new Exception('SQL query is required');
            }
            
            $stmt = $pdo->exec($sql);
            
            echo json_encode([
                'success' => true,
                'affected_rows' => $stmt
            ], JSON_UNESCAPED_UNICODE);
            break;
            
        default:
            throw new Exception('Invalid action');
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'error' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
?>
