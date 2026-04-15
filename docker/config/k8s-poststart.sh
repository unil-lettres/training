#!/bin/bash

if [ "$(pwd)" != "/var/www/training" ]; then
  cd /var/www/training || { echo "Failed to change directory to /var/www/training"; exit 1; }
fi

# Notify BugSnag about the deployment
php artisan bugsnag:deploy \
  --builder "Deployer"
