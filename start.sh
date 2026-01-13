#!/usr/bin/env bash
set -e

echo "=================================================="
echo "  Iniciando Laravel en Render - $(date)"
echo "=================================================="

# 1. Generar key SIEMPRE si está vacía o default
if [ -z "${APP_KEY:-}" ] || [[ "$APP_KEY" == "base64:"* && ${#APP_KEY} -lt 50 ]]; then
    echo "→ Generando nueva APP_KEY..."
    php artisan key:generate --force --no-interaction
fi

# 2. Dependencias (por si acaso falló en build)
composer install --no-dev --optimize-autoloader --no-interaction || true

# 3. Limpieza agresiva de cachés viejos/corruptos
php artisan optimize:clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# 4. Migraciones con tolerancia
php artisan migrate --force --no-interaction || true

# 5. Cachear todo (solo si todo está ok)
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 6. Permisos OBLIGATORIOS
echo "→ Ajustando permisos (muy importante en Render)"
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache || true

echo "✅ Todo listo! Iniciando nginx + php-fpm"
exec /start.sh   # o php-fpm si tu imagen lo usa directamente