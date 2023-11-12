#!/bin/bash

mkdir -p /var/www/logs

chmod 777 -R storage/

composer install

sleep 10
php artisan migrate
php artisan db:seed

php-fpm --nodaemonize

