FROM php:8.3-apache

# Установка зависимостей
RUN apt-get update && apt-get install -y \
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

# Установка ServerName по умолчанию и включение mod_rewrite
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf && a2enmod rewrite

# Копирование конфигурации Apache
COPY .docker/apache/laravel.conf /etc/apache2/sites-available/000-default.conf

# Открытие порта для доступа к приложению
EXPOSE 9000

# Запуск Apache
CMD ["apache2-foreground"]
