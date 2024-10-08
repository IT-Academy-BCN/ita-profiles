@echo off
docker exec -it php rm /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
docker compose restart php
docker exec -it php php artisan key:generate
