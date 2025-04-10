FROM php:8.1-fpm

RUN apt-get update \
    && apt-get install -y \
        libzip-dev \
        zip \
        unzip \
        librabbitmq-dev \
        amqp-tools \
        procps \
        libssl-dev \
        && pecl install swoole \
        && docker-php-ext-enable swoole \
    && docker-php-ext-configure zip \
    && docker-php-ext-install \
        zip \
        pdo \
        pdo_mysql \
        sockets \
    && docker-php-ext-install pcntl

# RabbitMQ
RUN pecl install amqp \
    && echo "extension=amqp.so" > /usr/local/etc/php/conf.d/docker-php-ext-amqp.ini

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

# EXPOSE 8000

# ENTRYPOINT ["bash", "docker/php-fpm/php-container-startup.sh"]
