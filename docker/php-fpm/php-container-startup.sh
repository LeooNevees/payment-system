#!/bin/bash

mkdir -p /var/www/logs

chmod 777 -R storage/

composer install

php artisan migrate

php artisan db:seed

php-fpm --nodaemonize

