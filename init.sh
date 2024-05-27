#!/bin/sh
/usr/local/bin/wait-for-it.sh mysql:3306 --timeout=120 --strict -- php artisan migrate:fresh
/usr/local/bin/wait-for-it.sh mysql:3306 --timeout=120 --strict -- php artisan db:seed
php artisan cache:clear
php artisan config:clear
php artisan config:cache
php artisan serve --host=0.0.0.0 --port=80
