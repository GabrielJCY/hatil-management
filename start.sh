#!/usr/bin/env bash
set -e

echo "===== 🚀 Iniciando Laravel en Render ====="

# Instalar dependencias de PHP / Laravel sin dev
composer install --no-dev --optimize-autoloader --no-interaction

# Limpiar cualquier cache previo
php artisan optimize:clear

# Ejecutar migraciones pendientes (solo si las hay)
php artisan migrate --force --no-interaction || true

# Cachear config, rutas y vistas
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Laravel listo. Iniciando servidor PHP..."

# Inicia Laravel en el puerto asignado por Render
php artisan serve --host=0.0.0.0 --port=${PORT:-10000}
