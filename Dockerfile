# FROM php:8.2-fpm

# # تثبيت dependencies
# RUN apt-get update && apt-get install -y \
#     git unzip libzip-dev libpq-dev libonig-dev \
#     zip curl libicu-dev g++ make supervisor \
#     libpng-dev libjpeg-dev libfreetype6-dev

# # تنصيب امتدادات PHP المطلوبة
# RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
#     && docker-php-ext-install pdo pdo_pgsql mbstring zip bcmath intl pcntl gd

# # Composer
# COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# WORKDIR /var/www/html
# COPY . /var/www/html

# # صلاحيات
# RUN chown -R www-data:www-data /var/www/html \
#     && chmod -R 755 /var/www/html/storage \
#     && chmod -R 755 /var/www/html/bootstrap/cache

# # تثبيت الحزم
# RUN composer install --no-dev --optimize-autoloader --no-interaction
# RUN php artisan schedule:run
# # RUN php artisan queue:work
# RUN php artisan storage:link
# # فتح البورت
# EXPOSE 8080
# CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]



# الصورة الأساسية
FROM php:8.2-fpm

# تثبيت الحزم الضرورية
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpq-dev libonig-dev \
    zip curl libicu-dev g++ make supervisor \
    libpng-dev libjpeg-dev libfreetype6-dev

# إعداد امتداد GD للصور
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql mbstring zip bcmath intl pcntl gd

# تثبيت Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# تحديد مجلد العمل
WORKDIR /var/www/html

# نسخ ملفات المشروع
COPY . /var/www/html

# ضبط الصلاحيات
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# تثبيت مكتبات Laravel
RUN composer install --no-dev --optimize-autoloader --no-interaction

# إنشاء الرابط للتخزين
RUN php artisan storage:link || true

# فتح المنفذ
EXPOSE 8080

# تشغيل خادم Laravel
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]
