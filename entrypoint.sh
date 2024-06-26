#!/bin/sh

# Elimina el archivo de configuración en caché si existe
if [ -f /var/www/html/bootstrap/cache/config.php ]; then
    rm /var/www/html/bootstrap/cache/config.php
fi

# Ejecuta las instrucciones de Composer y Artisan
composer install
cp .env.docker .env

php artisan optimize
php artisan clear-compiled
php artisan migrate:fresh --seed
php artisan l5-swagger:generate
php artisan key:generate
php artisan passport:install --force --no-interaction
php artisan config:clear
php artisan config:cache
php artisan cache:clear
chmod 777 -R storage

# Ejecuta el comando recibido como argumento del entrypoint
exec "$@"

