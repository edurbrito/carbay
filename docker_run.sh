#!/bin/bash
set -e

cd /var/www; php artisan config:cache
rm public/storage
php artisan storage:link
env >> /var/www/.env
php-fpm7.4 -D
nginx -g "daemon off;"
