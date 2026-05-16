FROM php:8.2-apache

# Habilitar módulos de Apache necesarios para Laravel
RUN a2enmod rewrite headers

# Instalar dependencias del sistema + Node.js 20
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev \
    libzip-dev zip unzip libpq-dev \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# Extensiones PHP necesarias para Laravel + PostgreSQL
RUN docker-php-ext-install pdo pdo_pgsql mbstring zip exif pcntl bcmath gd opcache

# Instalar Composer 2
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Apuntar el DocumentRoot de Apache a la carpeta public/ de Laravel
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' \
    /etc/apache2/sites-available/000-default.conf \
    && printf '<Directory /var/www/html/public>\n    AllowOverride All\n    Require all granted\n</Directory>\n' \
    >> /etc/apache2/apache2.conf

WORKDIR /var/www/html

COPY . .

# Crear directorios necesarios antes de que Composer ejecute scripts de artisan
RUN mkdir -p bootstrap/cache storage/framework/cache storage/framework/sessions storage/framework/views \
    && chmod -R 777 bootstrap/cache storage

# Instalar dependencias PHP solo de producción
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Compilar assets del frontend y eliminar node_modules
RUN npm ci && npm run build && rm -rf node_modules

# Ajustar permisos de los directorios que Laravel necesita escribir
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]
