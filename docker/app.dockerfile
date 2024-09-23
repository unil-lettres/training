FROM php:8.3-apache-bullseye AS base

ENV DOCKER_RUNNING=true

ENV NODE_VERSION=20
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

RUN a2enmod rewrite remoteip; \
    { \
    echo RemoteIPHeader X-Real-IP ; \
    echo RemoteIPTrustedProxy 10.0.0.0/8 ; \
    echo RemoteIPTrustedProxy 172.16.0.0/12 ; \
    echo RemoteIPTrustedProxy 192.168.0.0/16 ; \
    } > /etc/apache2/conf-available/remoteip.conf; \
    a2enconf remoteip

COPY docker/config/php.ini /usr/local/etc/php/php.ini
COPY docker/config/vhost.conf /etc/apache2/sites-available/000-default.conf

RUN mkdir -p /var/www/training
WORKDIR /var/www/training

FROM base AS dev

COPY docker/config/docker-dev-entrypoint.sh /bin/docker-entrypoint.sh
RUN chmod +x /bin/docker-entrypoint.sh

ENTRYPOINT ["/bin/docker-entrypoint.sh"]

FROM base AS prod

COPY docker/config/docker-prod-entrypoint.sh /bin/docker-entrypoint.sh
RUN chmod +x /bin/docker-entrypoint.sh

# Copy the application, except data listed in .dockerignore
COPY site/ /var/www/training

# Mount the secrets as environment variables
RUN --mount=type=secret,id=backpack_user,env=BACKPACK_USERNAME && \
    echo "------- Using secret backpack_user: $BACKPACK_USERNAME"

# Create the auth.json file for composer
RUN composer config http-basic.backpackforlaravel.com $BACKPACK_USERNAME $BACKPACK_PASSWORD

# Install php dependencies
RUN cd /var/www/training && \
    composer install --optimize-autoloader --no-dev --no-interaction

# Install js dependencies & compile
RUN cd /var/www/training && \
    npm install && \
    npm run prod

# Remove auth.json file since it's not needed anymore
RUN rm /var/www/training/auth.json

# Remove node_modules folder since it's not needed anymore
RUN rm -rf /var/www/training/node_modules

# Change ownership of the application to www-data
RUN chown -R www-data:www-data /var/www/training

# Run as www-data
USER 33

ENV RUN_APACHE_USER=www-data \
    RUN_APACHE_GROUP=www-data

ENTRYPOINT ["/bin/docker-entrypoint.sh"]
