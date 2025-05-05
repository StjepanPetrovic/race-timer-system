FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libpq-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_pgsql mbstring exif pcntl bcmath

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Set environment variable for composer
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV APP_ENV=prod

# Copy composer files first
COPY composer.json composer.lock symfony.lock ./

# Create necessary directories
RUN mkdir -p var/cache var/log \
    && chmod -R 777 var/cache var/log

# Install dependencies without scripts
RUN composer install \
    --no-dev \
    --no-scripts \
    --no-interaction \
    --no-progress \
    --optimize-autoloader

# Copy the rest of the application
COPY . .

# Run composer scripts after copying all files
RUN composer dump-autoload --optimize --no-dev \
    && composer run-script post-install-cmd --no-dev \
    && composer clear-cache

# Set proper permissions
RUN chown -R www-data:www-data /var/www

EXPOSE 9000
CMD ["php-fpm"]