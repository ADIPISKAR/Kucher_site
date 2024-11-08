# Используем PHP с FPM для работы с Nginx
FROM php:8.3-fpm

# Установка зависимостей
RUN apt-get update && apt-get install -y \
    nginx \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Копирование файлов Laravel
COPY . /var/www/html

# Установка прав доступа
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Установка зависимостей Laravel
WORKDIR /var/www/html
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Настройка Laravel
RUN cp .env.example .env \
    && php artisan key:generate \
    && php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache

# Копирование конфигурации Nginx
COPY ./nginx/nginx.conf /etc/nginx/conf.d/default.conf

# Настройка Nginx
RUN rm /etc/nginx/sites-enabled/default

# Открытие порта для Nginx
EXPOSE 80

# Запуск PHP-FPM и Nginx
CMD service php8.3-fpm start && nginx -g 'daemon off;'
