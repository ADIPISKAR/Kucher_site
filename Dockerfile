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
    && chmod -R 755 /var/www/html

# Установка зависимостей Laravel
WORKDIR /var/www/html
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Включение модуля rewrite и перезапуск Apache
RUN a2enmod rewrite && service apache2 restart

# Копирование конфигурации Apache
COPY .docker/apache/laravel.conf /etc/apache2/sites-available/000-default.conf

# Порт для доступа к приложению
EXPOSE 80

# Запуск Apache
CMD ["apache2-foreground"]
