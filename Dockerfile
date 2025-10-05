# Dockerfile
FROM php:8.2-fpm

# system deps
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpq-dev libonig-dev \
    zip curl nginx supervisor

# php extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl

# composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . /var/www/html

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html/storage

# build assets if you use npm (اختياري)
# RUN npm install && npm run prod

# Expose port
EXPOSE 8080

# start php-fpm and nginx via supervisor (أو اضبط الأمر لتشغيل php-fpm + nginx)
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
