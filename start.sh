#!/usr/bin/env bash
set -e

echo "===== 🚀 Iniciando despliegue Laravel en Render ====="

# Instalar dependencias sin dev
composer install --no-dev --optimize-autoloader --no-interaction

# Limpiar cualquier caché previo
php artisan optimize:clear

# Ejecutar migraciones pendientes (solo si hay)
php artisan migrate --force --no-interaction || true

# Cachear config, rutas y vistas
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Laravel preparado. Iniciando Nginx + PHP-FPM..."
exec /start.sh  # usa el script interno de la imagen base
