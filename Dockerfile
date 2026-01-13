# Usa PHP 8.2 con FPM
FROM php:8.2-fpm

# Instalar extensiones necesarias y herramientas
RUN apt-get update && apt-get install -y \
    zip unzip git libpq-dev \
    && docker-php-ext-install pdo_pgsql

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Directorio de trabajo
WORKDIR /var/www/html

# Copiar todos los archivos del proyecto
COPY . .

# Dar permisos de ejecución al script de inicio
RUN chmod +x start.sh

# Exponer el puerto que Laravel usará
EXPOSE 10000

# Comando para iniciar la app
CMD ["./start.sh"]
