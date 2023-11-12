#!/bin/bash

mkdir -p /var/www/logs

mkdir -p /var/www/html/docker/database/sqlite

touch /var/www/html/docker/database/sqlite/database.sqlite

chmod 777 -R storage/

composer install

sleep 10
php artisan migrate
php artisan db:seed

php-fpm --nodaemonize

