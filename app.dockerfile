FROM php:7.4-fpm

# Update packages
RUN apt-get update

# Install additional packages
RUN apt-get install -y git curl nano zip unzip zlib1g-dev libpng-dev libxml2-dev libzip-dev libonig-dev

# Install needed extensions
RUN apt-get clean; docker-php-ext-install pdo pdo_mysql zip gd bcmath tokenizer ctype json mbstring xml

# Installs Composer to easily manage your PHP dependencies.
RUN curl --silent --show-error https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Node
RUN apt-get update &&\
  apt-get install -y --no-install-recommends gnupg &&\
  curl -sL https://deb.nodesource.com/setup_12.x | bash - &&\
  apt-get update &&\
  apt-get install -y --no-install-recommends nodejs &&\
  npm config set registry https://registry.npm.taobao.org --global &&\
  npm install --global gulp-cli

CMD php-fpm
