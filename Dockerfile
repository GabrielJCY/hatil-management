# Etapa 1: Builder (instalamos dependencias)
FROM php:8.2-fpm-alpine AS builder

RUN apk add --no-cache \
    git \
    zip \
    unzip \
    libpq-dev \
    && docker-php-ext-install \
        pdo_pgsql \
        pgsql \
        opcache \
        pcntl \
        bcmath

# Composer oficial (sin -alpine)
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copia solo composer primero → cache inteligente
COPY composer.json composer.lock* ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader

# Copia el resto
COPY . .

# Optimizaciones Laravel + permisos
RUN composer dump-autoload --optimize --classmap-authoritative \
    && php artisan optimize:clear \
    && chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# Etapa 2: Imagen final (más liviana)
FROM php:8.2-fpm-alpine

RUN apk add --no-cache libpq

COPY --from=builder /var/www/html /var/www/html
COPY --from=builder /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Usuario no-root (seguridad)
RUN addgroup -g 1000 laravel && adduser -G laravel -u 1000 -D -s /bin/sh laravel
USER laravel

# Si usas nginx en otra etapa o servicio, exponer solo php-fpm
EXPOSE 9000