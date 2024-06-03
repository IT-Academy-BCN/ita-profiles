#!/bin/bash

php artisan migrate
php artisan db:seed
php artisan passport:install --force --no-interaction
php artisan l5-swagger:generate
php artisan config:cache
php artisan cache:clear
