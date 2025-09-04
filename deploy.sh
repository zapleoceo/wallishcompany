#!/bin/bash

# Минимальный скрипт деплоя для Wallish
# Обновляет код с GitHub без создания резервных копий

echo "🚀 ДЕПЛОЙ ПРОЕКТА WALLISH"

# Путь к проекту на сервере
PROJECT_PATH="/var/www/wallishcompa_usr/data/www/wallishcompany.com"

# Переходим в папку проекта
cd "$PROJECT_PATH"

echo "📁 Обновляем код с GitHub..."

# Получаем последние изменения
git fetch origin
git reset --hard origin/master

echo "🔧 Настраиваем права доступа..."

# Создаем необходимые директории
mkdir -p system/storage/cache
mkdir -p system/storage/logs
mkdir -p system/storage/download
mkdir -p system/storage/upload
mkdir -p system/storage/modification
mkdir -p image/cache
mkdir -p image/catalog

# Устанавливаем права
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;
chmod +x index.php admin/index.php catalog/index.php

# Системные директории
chmod 777 system/storage/cache
chmod 777 system/storage/logs
chmod 777 system/storage/download
chmod 777 system/storage/upload
chmod 777 system/storage/modification
chmod 777 image/cache
chmod 777 image/catalog

echo "✅ Деплой завершен!"
echo "🌐 Сайт: https://wallishcompany.com"
