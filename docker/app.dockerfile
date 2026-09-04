FROM php:8.5-apache-trixie AS base

ENV DOCKER_RUNNING=true
ENV LANG=en_US.UTF-8
ENV LANGUAGE=en_US:en
ENV LC_ALL=en_US.UTF-8
ENV TZ=Europe/Zurich

ENV NODE_VERSION=24
ENV PNPM_VERSION=11
ENV COMPOSER_VERSION=2.9.8

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
    libicu-dev \
    ca-certificates \
    gnupg \
    locales \
    tzdata

# Generate and set locale
RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && \
    locale-gen en_US.UTF-8 && \
    update-locale LANG=en_US.UTF-8

# Set timezone
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Install needed extensions
RUN apt-get clean; docker-php-ext-install pdo_mysql zip gd bcmath pcntl intl

# Install specific version of Composer
RUN curl --silent --show-error https://getcomposer.org/installer | php -- \
    --version=$COMPOSER_VERSION \
    --install-dir=/usr/local/bin --filename=composer

# Install specific version of Node & pnpm
RUN mkdir -p /etc/apt/keyrings; \
    curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key \
    | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg; \
    echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_VERSION.x nodistro main" \
    | tee /etc/apt/sources.list.d/nodesource.list; \
    apt-get update; \
    apt-get install -y --no-install-recommends nodejs && \
    corepack enable && \
    corepack prepare pnpm@$PNPM_VERSION --activate && \
    pnpm --version

# Replace the proxy IP with the real client IP
RUN a2enmod rewrite remoteip; \
    { \
    echo RemoteIPHeader X-Real-IP ; \
    echo RemoteIPTrustedProxy 10.0.0.0/8 ; \
    echo RemoteIPTrustedProxy 172.16.0.0/12 ; \
    echo RemoteIPTrustedProxy 192.168.0.0/16 ; \
    } > /etc/apache2/conf-available/remoteip.conf; \
    a2enconf remoteip

# Copy PHP configuration file
COPY docker/config/php.ini /usr/local/etc/php/php.ini

RUN mkdir -p /var/www/training
WORKDIR /var/www/training

FROM base AS dev

# Copy Apache configuration file
COPY docker/config/vhost-dev.conf /etc/apache2/sites-available/000-default.conf

# Copy the entrypoint script
COPY docker/config/docker-dev-entrypoint.sh /bin/docker-entrypoint.sh
RUN chmod +x /bin/docker-entrypoint.sh

ENTRYPOINT ["/bin/docker-entrypoint.sh"]

FROM base AS prod

# Copy Apache configuration file
COPY docker/config/vhost-prod.conf /etc/apache2/sites-available/000-default.conf

# Copy the application, except data listed in dockerignore
COPY site/ /var/www/training

# Install php dependencies
RUN cd /var/www/training && \
    composer install --optimize-autoloader --no-interaction --no-dev

# Install js dependencies, compile & remove folders to reduce image size
RUN cd /var/www/training && \
    pnpm install --frozen-lockfile && \
    pnpm run prod && \
    rm -rf /root/.local/share/pnpm/store && \
    rm -rf /var/www/training/node_modules

# Copy Kubernetes poststart script
COPY docker/config/k8s-poststart.sh /var/www/training/k8s-poststart.sh
RUN chmod +x /var/www/training/k8s-poststart.sh

# Change ownership of the application to www-data
RUN chown -R www-data:www-data /var/www/training

# Copy the entrypoint script
COPY docker/config/docker-prod-entrypoint.sh /bin/docker-entrypoint.sh
RUN chmod +x /bin/docker-entrypoint.sh

ENTRYPOINT ["/bin/docker-entrypoint.sh"]
CMD ["apache2-foreground"]
