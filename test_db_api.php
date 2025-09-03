<?php
/**
 * API для удаленной работы с БД и отладки проекта Wallish
 * Версия: 2.0
 * Дата: 3 сентября 2025
 */

// Отключаем вывод ошибок в браузер для безопасности
error_reporting(0);
ini_set('display_errors', 0);

// Устанавливаем заголовки
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

// Конфигурация
$config = [
    'db' => [
        'host' => 'localhost',
        'username' => 'holidaydecor_usr',
        'password' => 'fYoF4TVu9ukhjFnC',
        'database' => 'holidaydecor__db',
        'port' => 3306,
        'prefix' => 'oc_'
    ],
    'paths' => [
        'project_root' => '/var/www/wallishcompa_usr/data/www/wallishcompany.com',
        'logs' => [
            'nginx_frontend_error' => '/var/www/wallishcompa_usr/data/logs/wallishcompany.com-frontend.error.log',
            'nginx_frontend_access' => '/var/www/wallishcompa_usr/data/logs/wallishcompany.com-frontend.access.log',
            'apache_backend_error' => '/var/www/wallishcompa_usr/data/logs/wallishcompany.com-backend.error.log',
            'apache_backend_access' => '/var/www/wallishcompa_usr/data/logs/wallishcompany.com-backend.access.log',
            'php_error' => '/var/www/wallishcompa_usr/data/logs/wallishcompany.com-backend.error.log',
            'opencart_error' => '/var/www/wallishcompa_usr/data/www/wallishcompany.com/system/storage/logs/error.log',
            'opencart_access' => '/var/www/wallishcompa_usr/data/www/wallishcompany.com/system/storage/logs/access.log'
        ],
        'system' => [
            'php_ini' => '/var/www/wallishcompa_usr/data/php-bin/wallishcompany.com/php.ini',
            'tmp_dir' => '/var/www/wallishcompa_usr/data/tmp',
            'sessions' => '/var/www/wallishcompa_usr/data/tmp'
        ]
    ]
];

// Функция для безопасного ответа
function jsonResponse($data, $status = 200) {
    http_response_code($status);
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

// Функция для проверки авторизации (базовая защита)
function checkAuth() {
    $auth_header = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
    if (empty($auth_header) || !preg_match('/Bearer\s+(.*)$/i', $auth_header, $matches)) {
        return false;
    }
    
    $token = $matches[1];
    // Токены для отладки (временно, потом API будет удален)
    $valid_tokens = ['wallish_debug_2025', 'admin_debug_token'];
    return in_array($token, $valid_tokens);
}

// Функция для подключения к БД
function getDbConnection() {
    global $config;
    
    try {
        $dsn = "mysql:host={$config['db']['host']};dbname={$config['db']['database']};charset=utf8mb4;port={$config['db']['port']}";
        $pdo = new PDO($dsn, $config['db']['username'], $config['db']['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ]);
        return $pdo;
    } catch (PDOException $e) {
        return false;
    }
}

// Функция для чтения логов
function readLogFile($file_path, $lines = 100, $search = '') {
    if (!file_exists($file_path)) {
        return ['error' => 'Файл лога не найден: ' . $file_path];
    }
    
    if (!is_readable($file_path)) {
        return ['error' => 'Файл лога недоступен для чтения: ' . $file_path];
    }
    
    try {
        $content = file($file_path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if ($content === false) {
            return ['error' => 'Ошибка чтения файла лога'];
        }
        
        // Фильтруем по поисковому запросу
        if (!empty($search)) {
            $content = array_filter($content, function($line) use ($search) {
                return stripos($line, $search) !== false;
            });
        }
        
        // Берем последние N строк
        $content = array_slice($content, -$lines);
        
        return [
            'success' => true,
            'file' => $file_path,
            'total_lines' => count($content),
            'lines' => $lines,
            'content' => array_values($content),
            'file_size' => filesize($file_path),
            'last_modified' => date('Y-m-d H:i:s', filemtime($file_path))
        ];
    } catch (Exception $e) {
        return ['error' => 'Ошибка при чтении лога: ' . $e->getMessage()];
    }
}

// Функция для анализа ошибок в логах
function analyzeErrors($log_content) {
    $errors = [];
    $error_patterns = [
        'php_fatal' => '/Fatal error|Fatal Error/i',
        'php_warning' => '/Warning|Warning:/i',
        'php_notice' => '/Notice|Notice:/i',
        'mysql_error' => '/MySQL|SQLSTATE|PDOException/i',
        'nginx_error' => '/nginx|nginx error/i',
        'apache_error' => '/apache|Apache error/i',
        'opencart_error' => '/OpenCart|opencart/i'
    ];
    
    foreach ($log_content as $line) {
        foreach ($error_patterns as $type => $pattern) {
            if (preg_match($pattern, $line)) {
                $errors[] = [
                    'type' => $type,
                    'line' => $line,
                    'timestamp' => extractTimestamp($line)
                ];
            }
        }
    }
    
    return $errors;
}

// Функция для извлечения временной метки из строки лога
function extractTimestamp($line) {
    // Пытаемся найти временную метку в различных форматах
    $patterns = [
        '/\[(\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2})\]/',
        '/(\d{4}\/\d{2}\/\d{2} \d{2}:\d{2}:\d{2})/',
        '/(\d{2}\/\w{3}\/\d{4}:\d{2}:\d{2}:\d{2})/'
    ];
    
    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $line, $matches)) {
            return $matches[1];
        }
    }
    
    return 'Неизвестно';
}

// Функция для проверки системной информации
function getSystemInfo() {
    global $config;
    
    $info = [
        'server' => [
            'os' => php_uname('s') . ' ' . php_uname('r'),
            'php_version' => PHP_VERSION,
            'php_sapi' => php_sapi_name(),
            'memory_limit' => ini_get('memory_limit'),
            'max_execution_time' => ini_get('max_execution_time'),
            'upload_max_filesize' => ini_get('upload_max_filesize'),
            'post_max_size' => ini_get('post_max_size')
        ],
        'paths' => [
            'project_root' => $config['paths']['project_root'],
            'tmp_dir' => $config['paths']['system']['tmp_dir'],
            'sessions_dir' => $config['paths']['system']['sessions']
        ],
        'permissions' => [],
        'disk_space' => []
    ];
    
    // Проверяем права доступа к ключевым папкам
    $key_dirs = [
        $config['paths']['project_root'],
        $config['paths']['system']['tmp_dir'],
        $config['paths']['system']['sessions']
    ];
    
    foreach ($key_dirs as $dir) {
        if (is_dir($dir)) {
            $info['permissions'][$dir] = [
                'readable' => is_readable($dir),
                'writable' => is_writable($dir),
                'executable' => is_executable($dir),
                'permissions' => substr(sprintf('%o', fileperms($dir)), -4)
            ];
        }
    }
    
    // Проверяем свободное место на диске
    $info['disk_space'] = [
        'project_dir' => disk_free_space($config['paths']['project_root']),
        'tmp_dir' => disk_free_space($config['paths']['system']['tmp_dir'])
    ];
    
    return $info;
}

// Основная логика API
$action = $_GET['action'] ?? $_POST['action'] ?? '';

// Проверяем авторизацию для критических операций
if (in_array($action, ['read_logs', 'analyze_errors', 'system_info', 'debug_info'])) {
    if (!checkAuth()) {
        jsonResponse(['error' => 'Требуется авторизация'], 401);
    }
}

switch ($action) {
    case 'info':
        jsonResponse([
            'status' => 'success',
            'message' => 'API для удаленной работы с проектом Wallish',
            'version' => '2.0',
            'date' => date('Y-m-d H:i:s'),
            'endpoints' => [
                'info' => 'Информация об API',
                'test_tables' => 'Проверка таблиц БД',
                'check_orders' => 'Проверка заказов',
                'check_countries' => 'Проверка стран',
                'system_info' => 'Системная информация (требует авторизации)',
                'read_logs' => 'Чтение логов (требует авторизации)',
                'analyze_errors' => 'Анализ ошибок (требует авторизации)',
                'debug_info' => 'Отладочная информация (требует авторизации)'
            ]
        ]);
        break;
        
    case 'test_tables':
        $pdo = getDbConnection();
        if (!$pdo) {
            jsonResponse(['error' => 'Ошибка подключения к БД'], 500);
        }
        
        $tables = ['oc_setting', 'oc_order', 'oc_country', 'oc_customer', 'oc_banner_image_description'];
        $result = [];
        
        foreach ($tables as $table) {
            try {
                $stmt = $pdo->query("SELECT COUNT(*) as count FROM `$table`");
                $count = $stmt->fetch()['count'];
                $result[$table] = ['status' => 'ok', 'count' => $count];
            } catch (Exception $e) {
                $result[$table] = ['status' => 'error', 'message' => $e->getMessage()];
            }
        }
        
        jsonResponse(['status' => 'success', 'tables' => $result]);
        break;
        
    case 'check_orders':
        $pdo = getDbConnection();
        if (!$pdo) {
            jsonResponse(['error' => 'Ошибка подключения к БД'], 500);
        }
        
        try {
            $stmt = $pdo->query("SELECT order_id, payment_country_id, date_added FROM oc_order ORDER BY date_added DESC LIMIT 10");
            $orders = $stmt->fetchAll();
            
            jsonResponse(['status' => 'success', 'orders' => $orders]);
        } catch (Exception $e) {
            jsonResponse(['error' => 'Ошибка при получении заказов: ' . $e->getMessage()], 500);
        }
        break;
        
    case 'check_countries':
        $pdo = getDbConnection();
        if (!$pdo) {
            jsonResponse(['error' => 'Ошибка подключения к БД'], 500);
        }
        
        try {
            $stmt = $pdo->query("SELECT country_id, name, iso_code_2, iso_code_3 FROM oc_country ORDER BY country_id LIMIT 20");
            $countries = $stmt->fetchAll();
            
            jsonResponse(['status' => 'success', 'countries' => $countries]);
        } catch (Exception $e) {
            jsonResponse(['error' => 'Ошибка при получении стран: ' . $e->getMessage()], 500);
        }
        break;
        
    case 'system_info':
        $info = getSystemInfo();
        jsonResponse(['status' => 'success', 'system_info' => $info]);
        break;
        
    case 'read_logs':
        $log_type = $_GET['log_type'] ?? 'opencart_error';
        $lines = (int)($_GET['lines'] ?? 100);
        $search = $_GET['search'] ?? '';
        
        $log_file = $config['paths']['logs'][$log_type] ?? null;
        if (!$log_file) {
            jsonResponse(['error' => 'Неизвестный тип лога'], 400);
        }
        
        $log_data = readLogFile($log_file, $lines, $search);
        jsonResponse(['status' => 'success', 'log_data' => $log_data]);
        break;
        
    case 'analyze_errors':
        $log_type = $_GET['log_type'] ?? 'opencart_error';
        $lines = (int)($_GET['lines'] ?? 1000);
        
        $log_file = $config['paths']['logs'][$log_type] ?? null;
        if (!$log_file) {
            jsonResponse(['error' => 'Неизвестный тип лога'], 400);
        }
        
        $log_data = readLogFile($log_file, $lines);
        if (isset($log_data['error'])) {
            jsonResponse(['error' => $log_data['error']], 500);
        }
        
        $errors = analyzeErrors($log_data['content']);
        $summary = [
            'total_errors' => count($errors),
            'by_type' => array_count_values(array_column($errors, 'type')),
            'recent_errors' => array_slice($errors, -10)
        ];
        
        jsonResponse([
            'status' => 'success',
            'log_file' => $log_file,
            'analysis' => $summary,
            'all_errors' => $errors
        ]);
        break;
        
    case 'debug_info':
        $debug_info = [
            'timestamp' => date('Y-m-d H:i:s'),
            'request' => [
                'method' => $_SERVER['REQUEST_METHOD'],
                'uri' => $_SERVER['REQUEST_URI'],
                'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'Неизвестно',
                'ip' => $_SERVER['REMOTE_ADDR'] ?? 'Неизвестно'
            ],
            'system' => getSystemInfo(),
            'logs_status' => []
        ];
        
        // Проверяем статус всех логов
        foreach ($config['paths']['logs'] as $name => $path) {
            $debug_info['logs_status'][$name] = [
                'exists' => file_exists($path),
                'readable' => is_readable($path),
                'size' => file_exists($path) ? filesize($path) : 0,
                'last_modified' => file_exists($path) ? date('Y-m-d H:i:s', filemtime($path)) : 'N/A'
            ];
        }
        
        jsonResponse(['status' => 'success', 'debug_info' => $debug_info]);
        break;
        
    default:
        jsonResponse(['error' => 'Неизвестное действие'], 400);
        break;
}
?>
