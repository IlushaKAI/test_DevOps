FROM php:8.2-fpm-alpine

# Установка системных зависимостей
RUN apk add --no-cache \
    postgresql-dev \
    autoconf \
    g++ \
    make \
    git \
    unzip

# Установка PHP расширений
RUN docker-php-ext-install pdo pdo_pgsql

# Установка Redis расширения
RUN pecl install redis && docker-php-ext-enable redis

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Создание рабочей директории
WORKDIR /var/www

# Копирование composer.json и установка зависимостей
COPY composer.json ./
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Создание директории vendor если её нет
RUN mkdir -p /var/www/vendor

# Настройка прав доступа
RUN chown -R www-data:www-data /var/www

EXPOSE 9000
