FROM php:8.2-fpm-bullseye

ENV NODE_VERSION=18
ENV COMPOSER_VERSION=2.6

# Update packages
RUN apt-get update

# Install additional packages
RUN apt-get install -y \
    git \
    curl \
    nano \
    zip \
    unzip \
    openssl \
    zlib1g-dev \
    libpng-dev \
    libzip-dev \
    ca-certificates \
    gnupg

# Install needed extensions
RUN apt-get clean; docker-php-ext-install pdo_mysql zip gd bcmath pcntl

# Install specific version of Composer
RUN curl --silent --show-error https://getcomposer.org/installer | php -- \
    --$COMPOSER_VERSION \
    --install-dir=/usr/local/bin --filename=composer

# Install specific version of Node
RUN mkdir -p /etc/apt/keyrings; \
    curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key \
    | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg; \
    echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_VERSION.x nodistro main" \
    | tee /etc/apt/sources.list.d/nodesource.list; \
    apt-get update; \
    apt-get install -y --no-install-recommends nodejs

CMD php-fpm
