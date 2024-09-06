FROM php:8.2-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    locales \
    zip \
    unzip \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    nodejs \
    npm \
    libz-dev \
    libicu-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd sockets intl

RUN pecl install redis-5.3.7 \
    && docker-php-ext-enable redis

RUN pecl install xdebug-3.2.1 \
    && docker-php-ext-enable xdebug

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

EXPOSE 9000

CMD cp .env.example .env && \
    php artisan key:generate && \
    php artisan migrate:refresh --seed && \
    npm install && \
    npm run build && \
    php artisan storage:link && \
    php artisan optimize && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan event:cache && \
    php artisan view:cache && \
    php-fpm
