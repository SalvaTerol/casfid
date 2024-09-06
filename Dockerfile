# Use an official PHP runtime as a parent image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies
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

# Install Redis extension via PECL and enable it
RUN pecl install redis-5.3.7 \
    && docker-php-ext-enable redis

# Install Xdebug via PECL and enable it
RUN pecl install xdebug-3.2.1 \
    && docker-php-ext-enable xdebug

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www-data:www-data . /var/www

# Expose port 9000 and start PHP-FPM server
EXPOSE 9000

# Run necessary setup commands
CMD cp .env.example .env && \
    composer install && \
    php artisan key:generate && \
    php artisan migrate --force && \
    php artisan db:seed --force && \
    npm install && \
    npm run build && \
    php artisan optimize && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan event:cache && \
    php artisan view:cache && \
    php-fpm
