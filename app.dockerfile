FROM php:7.2-fpm

# Update packages
RUN apt-get update

# Install PHP and composer dependencies
RUN apt-get install -y git curl nano zlib1g-dev libpng-dev libxml2-dev

# Install needed extensions
# Here you can install any other extension that you need during the test and deployment process
RUN apt-get clean; docker-php-ext-install pdo pdo_mysql zip gd bcmath tokenizer ctype json mbstring xml

# Installs Composer to easily manage your PHP dependencies.
RUN curl --silent --show-error https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Node
RUN apt-get update &&\
  apt-get install -y --no-install-recommends gnupg &&\
  curl -sL https://deb.nodesource.com/setup_10.x | bash - &&\
  apt-get update &&\
  apt-get install -y --no-install-recommends nodejs &&\
  npm config set registry https://registry.npm.taobao.org --global &&\
  npm install --global gulp-cli

CMD php-fpm
