#!/bin/sh

# Elimina el archivo de configuración en caché si existe
if [ -f /var/www/html/bootstrap/cache/config.php ]; then
    rm /var/www/html/bootstrap/cache/config.php
fi

# Ejecuta las instrucciones de Composer y Artisan
composer install

if [ ! -f .env ]; then
    echo "[WARNING] - .env File Not Found! Using .env.docker File as .env"
    cp .env.docker .env
fi

php artisan optimize
php artisan clear-compiled

#Wait untill MYSQL Connection is ready:
#Fresh or not fresh...
until php artisan migrate:fresh --seed
do
  echo "Waiting for database connection..."
  # wait for 5 seconds before check again
  sleep 10
done

php artisan l5-swagger:generate
php artisan key:generate
php artisan passport:install --force --no-interaction
php artisan config:clear
php artisan config:cache
php artisan cache:clear
php artisan route:clear
chmod 777 -R storage

echo "Iniciando servicio cron..."
service cron start

php-fpm
