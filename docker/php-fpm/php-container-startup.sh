#!/bin/bash

mkdir -p /var/www/logs

mkdir -p /var/www/html/docker/database/sqlite

touch /var/www/html/docker/database/sqlite/database.sqlite

chmod 777 -R storage/

composer install

sleep 10
php artisan key:generate
php artisan migrate
php artisan db:seed

nohup php artisan queue:work --queue=transfer,deposit,notification,deadLetter &

php-fpm --nodaemonize

