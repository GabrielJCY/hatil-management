# Usa una imagen optimizada con PHP + Nginx lista para Laravel
FROM richarvey/nginx-php-fpm:latest

# Directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos del proyecto
COPY . .

# Configuración de entorno base
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV LOG_CHANNEL=stderr
ENV WEBROOT=/var/www/html/public
ENV COMPOSER_ALLOW_SUPERUSER=1
ENV PHP_ERRORS_STDERR=1

# Instalar dependencias PHP
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Copiar y dar permisos al script de inicio
COPY start.sh /start.sh
RUN chmod +x /start.sh

# Exponer el puerto 10000 (Render lo usa automáticamente)
EXPOSE 10000

# Iniciar con el script de arranque
CMD ["/start.sh"]
