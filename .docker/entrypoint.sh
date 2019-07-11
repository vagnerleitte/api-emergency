#!/bin/bash

composer install

php artisan cache:clear
chmod -R 775 storage
chmod -R 775 bootstrap

php artisan migrate
php artisan key:generate --force

php artisan passport:install
php artisan migrate:fresh --seed

php-fpm
