# 🔧 РУКОВОДСТВО ПО ИСПОЛЬЗОВАНИЮ API ОТЛАДКИ

## 📋 ОБЗОР API

**Файл:** `test_db_api.php`  
**Версия:** 2.0  
**Назначение:** Удаленная работа с БД и отладка проекта Wallish на сервере

## 🔐 АВТОРИЗАЦИЯ

### **Токены доступа:**
- `wallish_debug_2025` - основной токен для отладки
- `admin_debug_token` - резервный токен

### **Заголовок авторизации:**
```bash
Authorization: Bearer wallish_debug_2025
```

## 📡 ENDPOINTS API

### **1. Базовая информация** (без авторизации)
```bash
GET /test_db_api.php?action=info
```

### **2. Проверка таблиц БД** (без авторизации)
```bash
GET /test_db_api.php?action=test_tables
```

### **3. Проверка заказов** (без авторизации)
```bash
GET /test_db_api.php?action=check_orders
```

### **4. Проверка стран** (без авторизации)
```bash
GET /test_db_api.php?action=check_countries
```

### **5. Системная информация** (требует авторизации)
```bash
GET /test_db_api.php?action=system_info
Authorization: Bearer wallish_debug_2025
```

### **6. Чтение логов** (требует авторизации)
```bash
GET /test_db_api.php?action=read_logs&log_type=opencart_error&lines=100&search=error
Authorization: Bearer wallish_debug_2025
```

**Параметры:**
- `log_type` - тип лога (см. список ниже)
- `lines` - количество строк (по умолчанию 100)
- `search` - поисковый запрос (опционально)

### **7. Анализ ошибок** (требует авторизации)
```bash
GET /test_db_api.php?action=analyze_errors&log_type=opencart_error&lines=1000
Authorization: Bearer wallish_debug_2025
```

### **8. Отладочная информация** (требует авторизации)
```bash
GET /test_db_api.php?action=debug_info
Authorization: Bearer wallish_debug_2025
```

## 📁 ТИПЫ ЛОГОВ

### **Доступные логи:**
- `nginx_frontend_error` - ошибки Nginx (фронтенд)
- `nginx_frontend_access` - доступы Nginx (фронтенд)
- `apache_backend_error` - ошибки Apache (бэкенд)
- `apache_backend_access` - доступы Apache (бэкенд)
- `php_error` - ошибки PHP
- `opencart_error` - ошибки OpenCart
- `opencart_access` - доступы OpenCart

## 🚀 ПРИМЕРЫ ИСПОЛЬЗОВАНИЯ

### **Проверка работы API:**
```bash
curl "https://wallishcompany.com/test_db_api.php?action=info"
```

### **Чтение последних 50 ошибок OpenCart:**
```bash
curl -H "Authorization: Bearer wallish_debug_2025" \
     "https://wallishcompany.com/test_db_api.php?action=read_logs&log_type=opencart_error&lines=50"
```

### **Поиск ошибок MySQL в логах:**
```bash
curl -H "Authorization: Bearer wallish_debug_2025" \
     "https://wallishcompany.com/test_db_api.php?action=read_logs&log_type=opencart_error&search=MySQL&lines=200"
```

### **Анализ всех ошибок в логах:**
```bash
curl -H "Authorization: Bearer wallish_debug_2025" \
     "https://wallishcompany.com/test_db_api.php?action=analyze_errors&log_type=opencart_error&lines=1000"
```

### **Получение системной информации:**
```bash
curl -H "Authorization: Bearer wallish_debug_2025" \
     "https://wallishcompany.com/test_db_api.php?action=system_info"
```

## 🔍 АНАЛИЗ ОШИБОК

### **Типы ошибок, которые API может обнаружить:**
- `php_fatal` - критические ошибки PHP
- `php_warning` - предупреждения PHP
- `php_notice` - уведомления PHP
- `mysql_error` - ошибки MySQL/PDO
- `nginx_error` - ошибки Nginx
- `apache_error` - ошибки Apache
- `opencart_error` - ошибки OpenCart

### **Пример ответа анализа:**
```json
{
  "status": "success",
  "log_file": "/var/www/wallishcompa_usr/data/www/wallishcompany.com/system/storage/logs/error.log",
  "analysis": {
    "total_errors": 15,
    "by_type": {
      "php_warning": 8,
      "mysql_error": 5,
      "php_notice": 2
    },
    "recent_errors": [...]
  },
  "all_errors": [...]
}
```

## 🛠️ ОТЛАДКА ПРОБЛЕМ

### **1. Проверка подключения к БД:**
```bash
curl "https://wallishcompany.com/test_db_api.php?action=test_tables"
```

### **2. Проверка системных логов:**
```bash
curl -H "Authorization: Bearer wallish_debug_2025" \
     "https://wallishcompany.com/test_db_api.php?action=read_logs&log_type=apache_backend_error&lines=100"
```

### **3. Мониторинг ошибок в реальном времени:**
```bash
# Создайте скрипт для периодической проверки
while true; do
  curl -s -H "Authorization: Bearer wallish_debug_2025" \
       "https://wallishcompany.com/test_db_api.php?action=analyze_errors&log_type=opencart_error&lines=100" \
       | jq '.analysis.total_errors'
  sleep 60
done
```

## 📊 МОНИТОРИНГ И АЛЕРТЫ

### **Скрипт для автоматической проверки:**
```bash
#!/bin/bash
# check_errors.sh

API_URL="https://wallishcompany.com/test_db_api.php"
TOKEN="wallish_debug_2025"

# Проверяем количество ошибок
ERROR_COUNT=$(curl -s -H "Authorization: Bearer $TOKEN" \
  "$API_URL?action=analyze_errors&log_type=opencart_error&lines=1000" \
  | jq -r '.analysis.total_errors')

if [ "$ERROR_COUNT" -gt 10 ]; then
  echo "ВНИМАНИЕ: Обнаружено $ERROR_COUNT ошибок в логах!"
  # Отправка уведомления
  curl -X POST "https://api.telegram.org/bot<YOUR_BOT_TOKEN>/sendMessage" \
       -d "chat_id=<YOUR_CHAT_ID>&text=Ошибки в логах: $ERROR_COUNT"
fi
```

## 🔒 БЕЗОПАСНОСТЬ

### **Рекомендации:**
1. **Измените токены** по умолчанию в продакшене
2. **Ограничьте доступ** к API по IP адресам
3. **Используйте HTTPS** для всех запросов
4. **Логируйте все обращения** к API
5. **Регулярно обновляйте** токены доступа

### **Настройка ограничений по IP:**
```nginx
# В nginx конфигурации
location /test_db_api.php {
    allow 192.168.1.0/24;  # Ваша локальная сеть
    allow 10.0.0.0/8;      # Дополнительные сети
    deny all;
}
```

## 📞 ПОДДЕРЖКА

### **При возникновении проблем:**
1. Проверьте права доступа к файлам логов
2. Убедитесь в правильности путей в конфигурации
3. Проверьте работу PHP и расширений
4. Проверьте логи веб-сервера

### **Полезные команды для диагностики:**
```bash
# Проверка прав доступа к логам
ls -la /var/www/wallishcompa_usr/data/logs/

# Проверка размера логов
du -sh /var/www/wallishcompa_usr/data/logs/*

# Проверка последних ошибок в реальном времени
tail -f /var/www/wallishcompa_usr/data/logs/wallishcompany.com-backend.error.log
```

---
**Версия:** 2.0  
**Дата:** 3 сентября 2025  
**Статус:** Готово к использованию ✅
