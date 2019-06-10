#!/bin/bash

cd /var/www/html

## Copy config files
echo 'Copy Config Files'
cp /var/www/html/.env.example /var/www/html/.env
cp /var/www/html/config/gateways.sample.php /var/www/html/config/gateways.php

## Dependencies
echo 'Install Dependencies'
composer install

## Generate artisan key
echo 'Generate Artisan Key'
php artisan key:generate

## Database
echo 'Run Database Setup'
php artisan migrate
php artisan db:seed

## Run queue
echo 'Clean up and Run Queue'
php artisan optimize:clear
php artisan config:cache
php artisan queue:work bifrost-redis --tries=3 --timeout=90