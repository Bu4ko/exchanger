#!/bin/sh

set -e

cd /var/www
composer install
php artisan migrate
exec /usr/local/bin/docker-php-entrypoint $@
