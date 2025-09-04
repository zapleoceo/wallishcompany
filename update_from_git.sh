#!/bin/bash

# =============================================================================
# Скрипт автоматического обновления проекта Wallish с GitHub
# Для запуска на сервере Ubuntu
# =============================================================================

# Цвета для вывода
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Функция для вывода сообщений
print_message() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Функция для проверки ошибок
check_error() {
    if [ $? -ne 0 ]; then
        print_error "$1"
        exit 1
    fi
}

# =============================================================================
# НАСТРОЙКИ
# =============================================================================

# Путь к проекту на сервере
PROJECT_PATH="/var/www/wallishcompa_usr/data/www"
# Имя папки проекта
PROJECT_FOLDER="wallishcompany.com"
# Полный путь к проекту
FULL_PROJECT_PATH="$PROJECT_PATH/$PROJECT_FOLDER"
# URL репозитория GitHub
GIT_REPO="git@github.com:zapleoceo/wallishcompany.git"
# Ветка для обновления
GIT_BRANCH="master"

# =============================================================================
# НАЧАЛО СКРИПТА
# =============================================================================

echo "============================================================"
echo "  СКРИПТ ОБНОВЛЕНИЯ ПРОЕКТА WALLISH С GITHUB"
echo "============================================================"
echo ""

# Проверяем, что мы в правильной директории
if [ ! -d "$PROJECT_PATH" ]; then
    print_error "Директория $PROJECT_PATH не найдена!"
    print_error "Убедитесь, что вы запускаете скрипт с правильного сервера"
    exit 1
fi

print_message "Начинаем обновление проекта..."

# =============================================================================
# ШАГ 1: РЕЗЕРВНАЯ КОПИЯ
# =============================================================================

print_message "Создаем резервную копию текущего проекта..."

BACKUP_DIR="$PROJECT_PATH/backup_$(date +%Y%m%d_%H%M%S)"
if [ -d "$FULL_PROJECT_PATH" ]; then
    mkdir -p "$BACKUP_DIR"
    cp -r "$FULL_PROJECT_PATH" "$BACKUP_DIR/"
    print_success "Резервная копия создана в: $BACKUP_DIR"
else
    print_warning "Текущий проект не найден, резервная копия не создана"
fi

# =============================================================================
# ШАГ 2: УДАЛЕНИЕ ТЕКУЩЕГО ПРОЕКТА
# =============================================================================

print_message "Удаляем текущий проект..."

if [ -d "$FULL_PROJECT_PATH" ]; then
    rm -rf "$FULL_PROJECT_PATH"
    print_success "Текущий проект удален"
else
    print_warning "Папка проекта не найдена для удаления"
fi

# =============================================================================
# ШАГ 3: КЛОНИРОВАНИЕ С GITHUB
# =============================================================================

print_message "Клонируем проект с GitHub..."

cd "$PROJECT_PATH"
git clone "$GIT_REPO" "$PROJECT_FOLDER"
check_error "Ошибка при клонировании репозитория"

cd "$FULL_PROJECT_PATH"
git checkout "$GIT_BRANCH"
check_error "Ошибка при переключении на ветку $GIT_BRANCH"

print_success "Проект успешно склонирован с GitHub"

# =============================================================================
# ШАГ 4: НАСТРОЙКА ПРАВ ДОСТУПА
# =============================================================================

print_message "Настраиваем права доступа к файлам..."

# Создаем необходимые директории, если их нет
mkdir -p "$FULL_PROJECT_PATH/system/storage/cache"
mkdir -p "$FULL_PROJECT_PATH/system/storage/logs"
mkdir -p "$FULL_PROJECT_PATH/system/storage/download"
mkdir -p "$FULL_PROJECT_PATH/system/storage/upload"
mkdir -p "$FULL_PROJECT_PATH/system/storage/modification"
mkdir -p "$FULL_PROJECT_PATH/image/cache"
mkdir -p "$FULL_PROJECT_PATH/image/catalog"

# Устанавливаем права для директорий
find "$FULL_PROJECT_PATH" -type d -exec chmod 755 {} \;
print_success "Права для директорий установлены (755)"

# Устанавливаем права для файлов
find "$FULL_PROJECT_PATH" -type f -exec chmod 644 {} \;
print_success "Права для файлов установлены (644)"

# Устанавливаем специальные права для исполняемых файлов
chmod +x "$FULL_PROJECT_PATH/index.php"
chmod +x "$FULL_PROJECT_PATH/admin/index.php"
chmod +x "$FULL_PROJECT_PATH/catalog/index.php"
print_success "Права для исполняемых файлов установлены (755)"

# Устанавливаем права для системных директорий
chmod 777 "$FULL_PROJECT_PATH/system/storage/cache"
chmod 777 "$FULL_PROJECT_PATH/system/storage/logs"
chmod 777 "$FULL_PROJECT_PATH/system/storage/download"
chmod 777 "$FULL_PROJECT_PATH/system/storage/upload"
chmod 777 "$FULL_PROJECT_PATH/system/storage/modification"
chmod 777 "$FULL_PROJECT_PATH/image/cache"
chmod 777 "$FULL_PROJECT_PATH/image/catalog"
print_success "Права для системных директорий установлены (777)"

# Устанавливаем владельца файлов
if command -v chown &> /dev/null; then
    chown -R www-data:www-data "$FULL_PROJECT_PATH"
    print_success "Владелец файлов установлен (www-data:www-data)"
else
    print_warning "Команда chown не найдена, владелец не изменен"
fi

# =============================================================================
# ШАГ 5: ПРОВЕРКА КОНФИГУРАЦИИ
# =============================================================================

print_message "Проверяем конфигурацию..."

# Проверяем наличие основных файлов
if [ -f "$FULL_PROJECT_PATH/config.php" ]; then
    print_success "config.php найден"
else
    print_error "config.php не найден!"
fi

if [ -f "$FULL_PROJECT_PATH/admin/config.php" ]; then
    print_success "admin/config.php найден"
else
    print_error "admin/config.php не найден!"
fi

if [ -f "$FULL_PROJECT_PATH/catalog/config.php" ]; then
    print_success "catalog/config.php найден"
else
    print_error "catalog/config.php не найден!"
fi

# =============================================================================
# ШАГ 6: ОЧИСТКА И ФИНАЛИЗАЦИЯ
# =============================================================================

print_message "Выполняем финальную очистку..."

# Очищаем кэш Git
cd "$FULL_PROJECT_PATH"
git gc --prune=now
print_success "Git кэш очищен"

# Проверяем статус Git
print_message "Проверяем статус Git репозитория..."
git status --porcelain
if [ $? -eq 0 ]; then
    print_success "Git статус проверен"
else
    print_warning "Ошибка при проверке Git статуса"
fi

# =============================================================================
# ЗАВЕРШЕНИЕ
# =============================================================================

echo ""
echo "============================================================"
print_success "ОБНОВЛЕНИЕ ПРОЕКТА ЗАВЕРШЕНО УСПЕШНО!"
echo "============================================================"
echo ""
print_message "Проект обновлен в: $FULL_PROJECT_PATH"
print_message "Резервная копия сохранена в: $BACKUP_DIR"
echo ""
print_message "Следующие шаги:"
print_message "1. Проверьте работу сайта"
print_message "2. Проверьте работу админки"
print_message "3. При необходимости обновите конфигурацию БД"
echo ""
print_message "Для удаления резервной копии выполните:"
echo "rm -rf $BACKUP_DIR"
echo ""

# Возвращаемся в исходную директорию
cd "$PROJECT_PATH"

print_success "Скрипт завершен!"
exit 0
