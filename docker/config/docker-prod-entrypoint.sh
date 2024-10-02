#!/bin/bash
set -e

echoerr() { echo "$@" 1>&2; }

check_vars_exist() {
  var_names=("$@")

  for var_name in "${var_names[@]}"; do
    if [ -z "${!var_name}" ]; then
      echoerr "error: missing ${var_name} environment variable"
      exit 1
    fi
  done
}

# Ensure there is no local .env file
if [ -f ".env" ]; then
  mv .env .env.bak
  echoerr ".env file detected - moved to .env.bak"
  echoerr "Please update your configuration to use environment variables in the container!"
fi

# Check a number of essential variables are set
check_vars_exist \
  APP_KEY \
  APP_URL \
  DB_DATABASE \
  DB_HOST \
  DB_PASSWORD \
  DB_PORT \
  DB_USERNAME \
  MAIL_FROM_ADDRESS

# Hostname is extracted from APP_URL (https://myhost.com -> myhost.com)
hostname=$(echo "$APP_URL" | awk -F[/:] '{print $4}')

# Replace the Shibboleth configuration DNS placeholder by the actual DNS
if grep -q "myhost.com" "/etc/shibboleth/shibboleth2.xml"; then
  sed -i "s|myhost.com|$hostname|g" "/etc/shibboleth/shibboleth2.xml"
  sed -i "s|aai@$hostname|$MAIL_FROM_ADDRESS|g" "/etc/shibboleth/shibboleth2.xml"
  echo "Replaced all occurrences of DNS placeholder with $hostname in Shibboleth configuration."
else
  echo "Shibboleth configuration DNS placeholder not found. No action needed."
fi

# Check if Shibboleth key or certificate file exists, if not generate them
if [[ ! -f /etc/shibboleth/sp-key.pem && ! -f /etc/shibboleth/sp-cert.pem ]]; then
  echo "Shibboleth key and certificate files missing. Generated new key and certificate for $hostname hostname"
  shib-keygen -f -u _shibd -h $hostname -y 10 -o /etc/shibboleth/
else
  echo "Shibboleth key and certificate files already exist. No action needed."
fi

echo "Starting Migration..."
php artisan migrate --force

echo "Clearing caches..."
php artisan optimize:clear --no-interaction

echo "Create the symlink to make storage public..."
php artisan storage:link

# run commands from dockerfile
"${@}"
