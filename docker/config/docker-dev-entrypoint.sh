#!/bin/bash
set -e

# Ensure there is a local .env file
if [ ! -f ".env" ]; then
  cp .env.example .env
  echo "No .env file detected! The .env.example file has been copied to .env."
fi

echo "Install php dependencies..."
composer install --no-interaction

echo "Install js dependencies & compile for local dev..."
npm install
npm run dev

echo "Starting Migration..."
php artisan migrate --force

echo "If needed, create the symlink to make storage public..."
php artisan storage:link

trap "echo Catching SIGWINCH apache error and preventing it." SIGWINCH
exec apache2-foreground
