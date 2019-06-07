echo $PWD
cd /var/www/html

# Copy config files
cp /var/www/html/.env.example /var/www/html/.env
cp /var/www/html/config/gateways.sample.php /var/www/html/config/gateways.php

# Clear artisan
php artisan key:generate
php artisan optimize:clear
php artisan config:clear

# Database
php artisan migrate

# Dependencies
composer install
