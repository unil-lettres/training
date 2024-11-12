Master:
![ci](https://github.com/unil-lettres/training/workflows/ci/badge.svg?branch=master)
[![CodeFactor](https://www.codefactor.io/repository/github/unil-lettres/training/badge/master)](https://www.codefactor.io/repository/github/unil-lettres/training/overview/master)

Development:
![ci](https://github.com/unil-lettres/training/workflows/ci/badge.svg?branch=development)
[![CodeFactor](https://www.codefactor.io/repository/github/unil-lettres/training/badge/development)](https://www.codefactor.io/repository/github/unil-lettres/training/overview/development)

# Introduction

Development of technical skills in the Faculty of Arts.

A Laravel 11 app with a [Filament](https://filamentphp.com/) administration panel.

# Development with Docker

## Docker installation

A working [Docker](https://docs.docker.com/engine/install/) installation is mandatory.

## Environment files

Please make sure to copy & rename the **example.env** file to **.env**.

``cp docker/example.env docker/.env``

You can replace the values if needed, but the default ones should work for local development.

Please also make sure to copy & rename the docker-compose.override.yml.dev file to docker-compose.override.yml.

``cp docker-compose.override.yml.dev docker-compose.override.yml``

You can replace the values if needed, but the default ones should work for local development.

## Edit hosts file

Edit hosts file to point **training.lan** to your docker host.

## Installation & configuration

Build & run all the containers for this project.

``docker compose up`` (add -d if you want to run in the background and silence the logs)

## Populate the database

The first time you run the application you'll need to populate your database with initial data.

``docker exec train-app php artisan db:seed``

If you want completely wipe your database and populate it with fresh data, you can use the following command.

``docker exec train-app php artisan migrate:fresh --seed``

## Frontends

To access the main application please use the following link.

[http://training.lan:8686](http://training.lan:8686)

To access the administration please use the following link.

[http://training.lan:8686/admin](http://training.lan:8686/admin)

+ admin-user@example.com / password

### Telescope

To access the debug tool please use the following link.

[http://training.lan:8686/telescope](http://training.lan:8686/telescope)

### phpMyAdmin

To access the database please use the following link.

[http://training.lan:9999](http://training.lan:9999)

+ Server: train-mysql
+ Username: user
+ Password: password

### MailHog

To access mails please use the following link.

[http://training.lan:8025](http://training.lan:8025)

Or to get the messages in JSON format.

[http://training.lan:8025/api/v2/messages](http://training.lan:8025/api/v2/messages)

## PHP code style

All PHP files will be inspected during CI for code style issues. If you want to make a dry run beforehand, use the following command.

``docker exec train-app ./vendor/bin/pint --test``

And if you want to automatically fix the issues.

``docker exec train-app ./vendor/bin/pint``

## Tests

### Unit/Feature tests

To run the full suite:

`docker exec -it train-app php artisan test`

### Browser tests

To run the full suite:

`docker exec -it train-app php artisan dusk --env=testing`

To run a specific class:

`docker exec -it train-app php artisan dusk tests/Browser/MyTest.php --env=testing`

To view the browser tests running in the browser, go to [http://training.lan:4444](http://training.lan:4444), click on Sessions, you should see a line corresponding to the running tests and a camera icon next to it, click on it to open a VNC viewer with ("secret" as password).

# Deployment with Docker

## Environment files

Copy and rename the following environment files.

```
cp docker/example.env docker/.env
cp site/.env.example site/.env
```

You should replace the values since the default ones are not ready for production.

To authenticate with Shibboleth, don't forget to uncomment and set the `SHIB_HOSTNAME` and `SHIB_CONTACT` variables in `site/.env`, otherwise you only be abel to use the Filament authentication.

Please also make sure to copy & rename the **docker-compose.override.yml.prod** file to **docker-compose.override.yml**.

`cp docker-compose.override.yml.prod docker-compose.override.yml`

You can replace the values if needed, but the default ones should work for production.

## Installation & configuration

Build & run all the containers for this project.

`docker compose up -d`

## Reverse proxy

Use a reverse proxy configuration to map the url to port `8686`.

# Docker images

Changes in the `development` branch will create new images tagged `latest-dev` & `latest-stage`, while changes in the `master` branch will create an image tagged `latest`. And finally, when the new tag is created, an image with the matching tag will be automatically built.

# Error tracker

[https://www.bugsnag.com](https://www.bugsnag.com)

# Helm

The Helm charts for this project are available at [https://github.com/unil-lettres/k8s](https://github.com/unil-lettres/k8s), in the ``training`` directory.
