# Usamos PHP 8.2 con FPM
FROM php:8.2-fpm

# Instalar dependencias del sistema y extensiones necesarias
RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip unzip git \
    && docker-php-ext-install pdo_pgsql

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copiar el proyecto al contenedor
WORKDIR /var/www/html
COPY . .

# Instalar dependencias de Laravel
RUN composer install --no-dev --optimize-autoloader

# Generar cache de configuración y rutas
RUN php artisan config:cache
RUN php artisan route:cache

# Exponer el puerto que Render usará
EXPOSE 10000

# Comando para iniciar Laravel
CMD php artisan serve --host 0.0.0.0 --port 10000
