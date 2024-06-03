#!/bin/bash

php artisan migrate
php artisan db:seed
php artisan passport:install --force --no-interaction
