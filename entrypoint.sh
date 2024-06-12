#!/bin/sh

# Elimina el archivo de configuración en caché si existe
if [ -f /var/www/html/bootstrap/cache/config.php ]; then
    rm /var/www/html/bootstrap/cache/config.php
fi

# Ejecuta las instrucciones de Composer y Artisan
composer install
composer clear-cache
composer dump-autoload
php artisan cache:clear
php artisan config:clear
php artisan optimize
php artisan clear-compiled
php artisan key:generate
php artisan config:cache
chmod 777 -R storage

php artisan migrate:fresh --seed
php artisan l5-swagger:generate
cp .env.docker .env
php artisan config:clear
php artisan config:cache
php artisan cache:clear
php artisan key:generate
php artisan passport:install --force --no-interaction

# Ejecuta el comando recibido como argumento del entrypoint
exec "$@"
