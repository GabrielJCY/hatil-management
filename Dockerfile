# Etapa 1: Builder (dependencias)
FROM php:8.2-fpm-alpine AS builder

# Instalar dependencias del sistema + extensiones comunes de Laravel
RUN apk add --no-cache \
    git \
    zip \
    unzip \
    curl \
    libpq-dev \
    && docker-php-ext-install \
        pdo_pgsql \
        pgsql \
        opcache \
        pcntl \
        bcmath \
    && docker-php-ext-enable opcache

# Instalar composer
COPY --from=composer:2-alpine /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Primero copiamos solo los archivos necesarios para composer (mejor caché)
COPY composer.json composer.lock* ./

# Instalamos dependencias (sin scripts ni autoload para no ejecutar nada raro)
RUN composer install \
    --prefer-dist \
    --no-dev \
    --no-autoloader \
    --no-scripts \
    --no-interaction \
    --optimize-autoloader

# Ahora sí copiamos todo el proyecto
COPY . .

# Generamos autoload optimizado y otros assets
RUN composer dump-autoload --optimize --classmap-authoritative \
    && php artisan optimize:clear \
    && chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

# Etapa 2: Imagen final más liviana
FROM php:8.2-fpm-alpine

# Dependencias mínimas de runtime
RUN apk add --no-cache \
    libpq \
    && docker-php-ext-install pdo_pgsql opcache

# Copiamos solo lo necesario desde el builder
COPY --from=builder /var/www/html /var/www/html
COPY --from=builder /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Mejor seguridad: usuario no-root
RUN addgroup -g 1000 laravel \
    && adduser -G laravel -u 1000 -D -s /bin/sh laravel

USER laravel

# Recomendado: exponer puerto solo si realmente usas php-fpm directo (raro)
# Normalmente se expone el 80/443 del proxy inverso
# EXPOSE 9000

# Comando de inicio (tu start.sh debería hacer migrate, queue, etc)
CMD ["php-fpm"]

# Alternativa más común (si usas tu propio start.sh):
# COPY start.sh /usr/local/bin/start.sh
# RUN chmod +x /usr/local/bin/start.sh
# CMD ["/usr/local/bin/start.sh"]