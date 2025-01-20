#!/bin/sh

# Elimina el archivo de configuración en caché si existe
if [ -f /var/www/html/bootstrap/cache/config.php ]; then
    rm /var/www/html/bootstrap/cache/config.php
fi

composer install

if [ ! -f .env ]; then
    echo "[WARNING] - .env File Not Found! Using .env.docker File as .env"
    cp .env.docker .env
fi

# Cargar variables desde el archivo .env
export $(grep -v '^#' .env | xargs)

# Variables de entorno para MariaDB
DB_NAME=${DB_DATABASE:-laravel}
DB_USER=${DB_USERNAME:-user}
DB_PASS=${DB_PASSWORD:-password}

# Crear la base de datos y usuario si no existen
echo "Configuring MariaDB..."
until mysql -e "SELECT 1;" > /dev/null 2>&1; do
  echo "Waiting for MariaDB to be ready..."
  sleep 5
done

mysql <<EOSQL
CREATE DATABASE IF NOT EXISTS \`${DB_NAME}\`;
CREATE USER IF NOT EXISTS '${DB_USER}'@'%' IDENTIFIED BY '${DB_PASS}';
GRANT ALL PRIVILEGES ON \`${DB_NAME}\`.* TO '${DB_USER}'@'%';
FLUSH PRIVILEGES;
EOSQL

php artisan optimize
php artisan clear-compiled

until php artisan migrate --force
do
  echo "Waiting for database connection..."
  sleep 10
done

php artisan db:seed
php artisan l5-swagger:generate
php artisan key:generate
php artisan passport:install --force --no-interaction
php artisan config:cache
php artisan route:cache
php artisan storage:link
chmod 777 -R storage

