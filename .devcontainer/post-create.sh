#!/bin/bash

if [ -n "$CODESPACE_NAME" ]; then
  echo "Set the APP_URL envar with the Codespace URL..."
  APP_URL="https://$CODESPACE_NAME-8686.app.github.dev"
  if grep -q '^APP_URL=' ./site/.env; then
    sed -i "s|^APP_URL=.*|APP_URL=$APP_URL|" ./site/.env
  else
    echo "APP_URL=$APP_URL" >> ./site/.env
  fi

  # Ensure the CODESPACE_NAME is available in Laravel
  echo "CODESPACE_NAME=$CODESPACE_NAME" >> ./site/.env
fi

echo "Waiting for composer dependencies to be installed..."
while [ ! -f ./site/vendor/autoload.php ]; do
    sleep 1
done

echo "Seed the database..."
cd ./site
php artisan db:seed
