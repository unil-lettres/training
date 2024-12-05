#!/usr/bin/env bash

# Copy the .env file for CI
cp .env.dusk.ci .env
# Remove the .env file used for local testing
# to fallback to the main .env file
rm .env.dusk.testing

# Install php dependencies
composer install --no-interaction --no-progress --prefer-dist --optimize-autoloader

# Install js dependencies & compile
npm install
npm run prod

# Generate the app key
php artisan key:generate

# Run migrations & seed data
php artisan migrate:fresh --seed

# Create the symlink to make storage public
php artisan storage:link
