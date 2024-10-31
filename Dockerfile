FROM php:8.3-apache

# Установка зависимостей, таких как расширения PHP и Composer
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

# Копирование файлов Laravel в рабочую директорию контейнера
COPY . /var/www/html

# Установка прав доступа
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Запуск Composer для установки зависимостей
WORKDIR /var/www/html
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Включение модуля rewrite
RUN a2enmod rewrite

# Копирование конфигурации Apache
COPY .docker/apache/laravel.conf /etc/apache2/sites-available/000-default.conf

# Порт для доступа к веб-приложению
EXPOSE 80

CMD ["apache2-foreground"]
