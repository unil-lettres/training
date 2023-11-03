FROM php:8.2-fpm-bullseye

ENV NODE_VERSION=18
ENV COMPOSER_VERSION=2.6

# Update packages
RUN apt-get update

# Install additional packages
RUN apt-get install -y git curl nano zip unzip openssl zlib1g-dev libpng-dev libzip-dev

# Install needed extensions
RUN apt-get clean; docker-php-ext-install pdo_mysql zip gd bcmath pcntl

# Install specific version of Composer
RUN curl --silent --show-error https://getcomposer.org/installer | php -- \
    --$COMPOSER_VERSION \
    --install-dir=/usr/local/bin --filename=composer

# Install specific version of Node
RUN curl -sL https://deb.nodesource.com/setup_$NODE_VERSION.x | bash - &&\
    apt-get update &&\
    apt-get install -y --no-install-recommends nodejs

CMD php-fpm
