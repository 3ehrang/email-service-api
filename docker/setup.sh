echo "Run initial setup"
cd /var/www/html

echo "Copy files"
## Copy config files
cp /var/www/html/.env.example /var/www/html/.env
cp /var/www/html/config/gateways.sample.php /var/www/html/config/gateways.php

echo 'Generate artisan key'
## Generate artisan key
php artisan key:generate

echo 'Run migrations'
## Database
php artisan migrate

echo 'Install dependencies'
## Dependencies
composer install

echo 'Run Queue'
## Run queue
php artisan optimize:clear
php artisan config:cache
php artisan queue:work --tries=3 --timeout=90
