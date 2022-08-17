FROM php:8.0-fpm

# Update packages
RUN apt-get update

# Install additional packages
RUN apt-get install -y git curl nano zip unzip openssl zlib1g-dev libpng-dev libzip-dev

# Install needed extensions
RUN apt-get clean; docker-php-ext-install pdo_mysql zip gd bcmath

# Installs Composer to easily manage your PHP dependencies.
RUN curl --silent --show-error https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Node
RUN apt-get update &&\
  apt-get install -y --no-install-recommends gnupg &&\
  curl -sL https://deb.nodesource.com/setup_16.x | bash - &&\
  apt-get update &&\
  apt-get install -y --no-install-recommends nodejs &&\
  npm install --global gulp-cli

CMD php-fpm
