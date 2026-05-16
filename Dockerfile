FROM php:8.2-apache

# Enable Apache modules required by Laravel
RUN a2enmod rewrite headers

# Install system dependencies + Node.js 20
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev \
    libzip-dev zip unzip libpq-dev \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# PHP extensions needed by Laravel + PostgreSQL
RUN docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl bcmath gd opcache

# Install Composer 2
COPY --from=composer:2 /usr/local/bin/composer /usr/local/bin/composer

# Point Apache document root to Laravel's public/ folder
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/000-default.conf \
    && printf '<Directory /var/www/html/public>\n    AllowOverride All\n    Require all granted\n</Directory>\n' \
    >> /etc/apache2/apache2.conf

WORKDIR /var/www/html

COPY . .

# Production PHP dependencies only
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Build frontend assets and remove dev files
RUN npm ci && npm run build && rm -rf node_modules

# Permissions for Laravel writable directories
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]
