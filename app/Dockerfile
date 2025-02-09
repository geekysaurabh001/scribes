# Use PHP 8.4 FPM Alpine as base image
FROM php:8.4.3-fpm-alpine

# Install required PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Set the working directory inside the container
WORKDIR /var/www/html

# Allow Composer to run as root
ENV COMPOSER_ALLOW_SUPERUSER=1

# Copy Composer from the official image
COPY --from=composer:2.8.5 /usr/bin/composer /usr/bin/composer

# Copy Composer files first (helps with caching)
COPY ./composer.json ./composer.lock ./

# Install dependencies without development packages
RUN composer install --prefer-dist --no-dev --no-scripts --no-progress --no-interaction

# Copy the rest of the application code
COPY . .

# Optimize autoloading
RUN composer dump-autoload --optimize

# Expose the required port for Render (10000)
EXPOSE 10000

# Start PHP-FPM
# CMD ["php-fpm"]
CMD ["php", "-S", "0.0.0.0:10000", "-t", "public"]