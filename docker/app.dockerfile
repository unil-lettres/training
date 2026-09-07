FROM php:8.5-apache-trixie AS base

ENV DOCKER_RUNNING=true
ENV LANG=en_US.UTF-8
ENV LANGUAGE=en_US:en
ENV LC_ALL=en_US.UTF-8
ENV TZ=Europe/Zurich

ENV NODE_VERSION=24
ENV PNPM_VERSION=12
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

# Install specific version of Node & enable Corepack
RUN mkdir -p /etc/apt/keyrings; \
    curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key \
    | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg; \
    echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_VERSION.x nodistro main" \
    | tee /etc/apt/sources.list.d/nodesource.list; \
    apt-get update; \
    apt-get install -y --no-install-recommends nodejs && \
    corepack enable

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

# Create an unprivileged runtime user and prepare Apache runtime directories
RUN groupadd -r dockeruser --gid=1000 && \
    useradd -r -g dockeruser --uid=1000 \
      --create-home --home-dir=/home/dockeruser \
      --shell=/sbin/nologin dockeruser && \
    # keep Apache's configured runtime identity aligned with the container user
    sed -i 's/: ${APACHE_RUN_USER:=www-data}/: ${APACHE_RUN_USER:=dockeruser}/' /etc/apache2/envvars && \
    sed -i 's/: ${APACHE_RUN_GROUP:=www-data}/: ${APACHE_RUN_GROUP:=dockeruser}/' /etc/apache2/envvars

# Install pnpm as dockeruser so Corepack's configuration and cache remain accessible
RUN su -s /bin/sh dockeruser -c \
    'corepack install --global pnpm@'"$PNPM_VERSION"' && pnpm --version'

# Allow Apache to write its PID, lock, and log files without root privileges
RUN mkdir -p /var/run/apache2 /var/lock/apache2 /var/log/apache2 && \
    chown -R dockeruser:dockeruser /var/run/apache2 /var/lock/apache2 /var/log/apache2

FROM base AS dev

# Copy Apache configuration file
COPY --chown=dockeruser:dockeruser docker/config/vhost-dev.conf /etc/apache2/sites-available/000-default.conf

# Copy the entrypoint script
COPY --chown=dockeruser:dockeruser docker/config/docker-dev-entrypoint.sh /bin/docker-entrypoint.sh
RUN chmod +x /bin/docker-entrypoint.sh

# Switch to unprivileged user
USER dockeruser

ENTRYPOINT ["/bin/docker-entrypoint.sh"]
CMD ["apache2-foreground"]

FROM base AS prod

# Copy Apache configuration file
COPY --chown=dockeruser:dockeruser docker/config/vhost-prod.conf /etc/apache2/sites-available/000-default.conf

# Copy the application, set ownership and permissions
COPY --chown=dockeruser:dockeruser site/ /var/www/training
RUN chown dockeruser:dockeruser /var/www/training

# Switch to unprivileged user
USER dockeruser

# Install php dependencies
RUN cd /var/www/training && \
    composer install --optimize-autoloader --no-interaction --no-dev

# Install js dependencies, compile & remove folders to reduce image size
RUN cd /var/www/training && \
    pnpm install --frozen-lockfile && \
    pnpm run prod && \
    rm -rf "$(pnpm store path)" && \
    rm -rf /var/www/training/node_modules

# Copy Kubernetes poststart script
COPY --chown=dockeruser:dockeruser docker/config/k8s-poststart.sh /var/www/training/k8s-poststart.sh
RUN chmod +x /var/www/training/k8s-poststart.sh

# Copy the entrypoint script
COPY --chown=dockeruser:dockeruser docker/config/docker-prod-entrypoint.sh /bin/docker-entrypoint.sh
RUN chmod +x /bin/docker-entrypoint.sh

ENTRYPOINT ["/bin/docker-entrypoint.sh"]
CMD ["apache2-foreground"]
