# Use an official PHP runtime as a parent image
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install dependencies
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
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd sockets

# Install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www-data:www-data . /var/www

# Set the user to www-data
USER www-data

# Expose port 9000
EXPOSE 9000

# Run application setup commands
CMD cp .env.example .env && \
    composer install && \
    php artisan key:generate && \
    php artisan migrate --force && \
    npm install && \
    npm run build && \
    php artisan optimize && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan event:cache && \
    php artisan view:cache && \
    php-fpm
