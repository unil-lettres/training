#!/usr/bin/env bash

# Create the Laravel .env file
if [ -z "$CI" ]; then
  # Not CI
  cp .env.example .env
else
  # CI
  cp .env.testing .env
fi

# Install php dependencies
composer install --no-interaction

# Update the application key
php artisan key:generate

if [ -z "$CI" ]; then
  # Not CI
  npm install
  npm run dev
else
  # CI
  php artisan config:clear
  php artisan config:cache
fi

# Run migrations
php artisan migrate --force

# Seeding dummy data
php artisan db:seed
