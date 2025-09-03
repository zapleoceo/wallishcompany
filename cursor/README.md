# 📚 ДОКУМЕНТАЦИЯ ПРОЕКТА WALLISH

## 🔧 ВРЕМЕННЫЕ ИНСТРУКЦИИ ПО ОТЛАДКЕ

### **API для отладки (ВРЕМЕННО)**

**Файл:** `test_db_api.php`  
**Статус:** Временный, будет удален после деплоя

#### **Токены доступа:**
- `wallish_debug_2025` - основной токен для отладки
- `admin_debug_token` - резервный токен

#### **Примеры использования:**
```bash
# Проверка работы API
curl "https://wallishcompany.com/test_db_api.php?action=info"

# Чтение логов с авторизацией
curl -H "Authorization: Bearer wallish_debug_2025" \
     "https://wallishcompany.com/test_db_api.php?action=read_logs&log_type=opencart_error&lines=50"

# Анализ ошибок
curl -H "Authorization: Bearer wallish_debug_2025" \
     "https://wallishcompany.com/test_db_api.php?action=analyze_errors&log_type=opencart_error&lines=1000"
```

#### **Доступные действия:**
- `info` - информация об API (без авторизации)
- `test_tables` - проверка таблиц БД (без авторизации)
- `check_orders` - проверка заказов (без авторизации)
- `check_countries` - проверка стран (без авторизации)
- `system_info` - системная информация (требует авторизации)
- `read_logs` - чтение логов (требует авторизации)
- `analyze_errors` - анализ ошибок (требует авторизации)
- `debug_info` - отладочная информация (требует авторизации)

## 🚨 КРИТИЧЕСКИЕ ДЕЙСТВИЯ ДЛЯ ПРОДАКШЕНА

### **1. PayPal API ключи**
```php
// В админке OpenCart: Расширения → Платежи → PayPal Express
// Заполнить поля:
// - Client ID (Sandbox)
// - Client Secret (Sandbox)  
// - Client ID (Live)
// - Client Secret (Live)
```

### **2. База данных**
```sql
-- Обновить данные в таблице oc_order:
UPDATE oc_order SET payment_country_id = 300001 WHERE payment_country_id IN (1, 192);
```

### **3. Удаление API отладки**
```bash
# После успешного деплоя удалить:
rm test_db_api.php
rm API_USAGE_GUIDE.md
```

## 📁 СТРУКТУРА ПАПКИ CURSOR

- `SECURITY_AUDIT_REPORT_2025.md` - отчет по безопасности
- `COMPLETED_TASKS_REPORT.md` - отчет о выполненных задачах
- `README.md` - этот файл с инструкциями

## ⚠️ ВАЖНЫЕ ЗАМЕЧАНИЯ

1. **API отладки временный** - удалить после деплоя
2. **Токены простые** - только для локальной отладки
3. **PayPal настроить** - критично для работы платежей
4. **БД обновить** - исправить ошибки с странами

---
**Дата создания:** 3 сентября 2025  
**Статус:** Временная документация для деплоя
