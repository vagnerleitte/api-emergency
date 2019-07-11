#!/bin/bash
composer install

php artisan migrate
php artisan key:generate --force

php artisan passport:install

php artisan migrate:fresh --seed

php-fpm
