# 🚀 ИНСТРУКЦИЯ ПО РАЗВЕРТЫВАНИЮ ПРОЕКТА WALLISH

## 📋 ПРЕДВАРИТЕЛЬНЫЕ ТРЕБОВАНИЯ

### **На сервере Ubuntu должны быть установлены:**
- Git
- PHP 7.4+ (или совместимая версия)
- MySQL/MariaDB
- Apache/Nginx
- SSH доступ к GitHub

## 🔧 НАСТРОЙКА SSH КЛЮЧЕЙ

### **1. Генерация SSH ключа на сервере:**
```bash
ssh-keygen -t ed25519 -C "your_email@example.com"
```

### **2. Добавление публичного ключа в GitHub:**
```bash
cat ~/.ssh/id_ed25519.pub
```
Скопируйте содержимое и добавьте в GitHub: Settings → SSH and GPG keys → New SSH key

### **3. Тестирование SSH соединения:**
```bash
ssh -T git@github.com
```

## 📁 СТРУКТУРА ПРОЕКТА НА СЕРВЕРЕ

```
/home/wallishcompa_usr/public_html/
├── wallish/                    # Основная папка проекта
│   ├── admin/                  # Админ панель
│   ├── catalog/                # Фронтенд
│   ├── system/                 # Системные файлы
│   ├── image/                  # Изображения
│   ├── config.php              # Основной конфиг
│   └── .htaccess              # Apache конфигурация
└── backup_YYYYMMDD_HHMMSS/    # Резервные копии
```

## 🚀 АВТОМАТИЧЕСКОЕ ОБНОВЛЕНИЕ

### **1. Загрузка скрипта на сервер:**
```bash
# Скопируйте update_from_git.sh на сервер
scp update_from_git.sh wallishcompa_usr@your_server:/home/wallishcompa_usr/
```

### **2. Установка прав на выполнение:**
```bash
chmod +x update_from_git.sh
```

### **3. Запуск скрипта:**
```bash
./update_from_git.sh
```

## 📝 ЧТО ДЕЛАЕТ СКРИПТ

### **Автоматически выполняет:**
1. ✅ **Создание резервной копии** текущего проекта
2. ✅ **Удаление** старой версии проекта
3. ✅ **Клонирование** с GitHub репозитория
4. ✅ **Настройку прав доступа** для всех файлов
5. ✅ **Проверку конфигурации** проекта
6. ✅ **Очистку Git кэша**

### **Устанавливает права доступа:**
- **Директории:** 755 (rwxr-xr-x)
- **Файлы:** 644 (rw-r--r--)
- **Исполняемые файлы:** 755 (rwxr-xr-x)
- **Системные директории:** 777 (rwxrwxrwx)

## ⚙️ РУЧНАЯ НАСТРОЙКА

### **Если нужно изменить пути в скрипте:**
Отредактируйте переменные в начале `update_from_git.sh`:

```bash
# Путь к проекту на сервере
PROJECT_PATH="/home/wallishcompa_usr/public_html"
# Имя папки проекта
PROJECT_FOLDER="wallish"
# URL репозитория GitHub
GIT_REPO="git@github.com:zapleoceo/wallishcompany.git"
```

### **Если нужно изменить владельца файлов:**
В скрипте по умолчанию: `www-data:www-data`
Для изменения отредактируйте строку:
```bash
chown -R www-data:www-data "$FULL_PROJECT_PATH"
```

## 🔍 ПРОВЕРКА РАБОТЫ

### **После выполнения скрипта проверьте:**
1. **Сайт работает** - откройте в браузере
2. **Админка работает** - войдите в админ панель
3. **Изображения загружаются** - проверьте главную страницу
4. **AJAX работает** - проверьте функциональность

### **Проверка логов:**
```bash
tail -f /home/wallishcompa_usr/public_html/wallish/system/storage/logs/error.log
```

## 🆘 УСТРАНЕНИЕ ПРОБЛЕМ

### **Ошибка SSH:**
```bash
# Проверьте SSH ключи
ls -la ~/.ssh/
# Тестируйте соединение
ssh -T git@github.com
```

### **Ошибка прав доступа:**
```bash
# Проверьте владельца
ls -la /home/wallishcompa_usr/public_html/wallish/
# Установите права вручную
chmod -R 755 /home/wallishcompa_usr/public_html/wallish/
```

### **Ошибка Git:**
```bash
# Проверьте статус
cd /home/wallishcompa_usr/public_html/wallish/
git status
# Очистите кэш
git gc --prune=now
```

## 📞 ПОДДЕРЖКА

### **При возникновении проблем:**
1. Проверьте логи ошибок
2. Убедитесь в правильности путей
3. Проверьте SSH доступ к GitHub
4. Проверьте права доступа к папкам

### **Полезные команды:**
```bash
# Проверка версии PHP
php -v

# Проверка версии Git
git --version

# Проверка свободного места
df -h

# Проверка процессов Apache
ps aux | grep apache
```

---
**Версия:** 1.0  
**Дата:** 3 сентября 2025  
**Статус:** Готово к использованию ✅
