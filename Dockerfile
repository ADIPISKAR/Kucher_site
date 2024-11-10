FROM php:8.3-fpm

# Устанавливаем необходимые зависимости
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    nginx \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip

# Копируем Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Копируем все файлы проекта в контейнер
COPY . /var/www/html

# Права доступа
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Рабочая директория
WORKDIR /var/www/html   

# Устанавливаем зависимости через Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Настройка Laravel
RUN cp .env.example .env \
    && php artisan key:generate \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Копируем файл конфигурации Nginx
COPY laravel.conf /etc/nginx/nginx.conf

# Открываем порт 80 для Nginx
EXPOSE 80

# Запускаем Nginx и PHP-FPM
CMD service nginx start && php-fpm
