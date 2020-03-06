Master:
[![Build Status](https://travis-ci.com/unil-lettres/training.svg?token=T7puWy4nJeaNtH7s3vRB&branch=master)](https://travis-ci.com/unil-lettres/training)
[![CodeFactor](https://www.codefactor.io/repository/github/unil-lettres/training/badge/master)](https://www.codefactor.io/repository/github/unil-lettres/training/overview/master)

Development:
[![Build Status](https://travis-ci.com/unil-lettres/training.svg?token=T7puWy4nJeaNtH7s3vRB&branch=development)](https://travis-ci.com/unil-lettres/training)
[![CodeFactor](https://www.codefactor.io/repository/github/unil-lettres/training/badge/development)](https://www.codefactor.io/repository/github/unil-lettres/training/overview/development)

# Introduction

Development of technical skills in the Faculty of Arts.

A Laravel 7 app with a Backpack administration.

# Development

## Docker installation

A working [Docker](https://docs.docker.com/engine/installation/) installation is mandatory.

## Docker environment variables file

Please make sure to copy & rename the **example.env** file to **.env**.

``cp env.example .env``

You can replace the values if needed, but the default ones should work.

## Edit hosts file

Edit hosts file to point **training.lan** to you docker host.

## Environment installation & configuration

Run the following docker commands from the project root directory.

Build & run all the containers for this project

``docker-compose up -d``

Install php dependencies

``docker exec train-app composer install``

Update the Laravel .env file

``docker exec train-app cp .env.example .env``

Update the application key

``docker exec train-app php artisan key:generate``

Install js dependencies

``docker exec train-app npm install``

``docker exec train-app npm run dev``

Run migrations

``docker exec train-app php artisan migrate --no-interaction --force``

Seeding first user

``docker exec train-app php artisan db:seed`` 

This is only needed when you launch the project for the first time. After that you can simply use the following command from the project root directory.

``docker-compose up -d``

## Frontends

To access the main application please use the following link.

[http://training.lan:8686](http://training.lan:8686)

To access the administration please use the following link.

[http://training.lan:8686/admin](http://training.lan:8686/admin)

login: first-user@example.com
password: password

### Telescope

To access the debug tool please use the following link.

[http://training.lan:8686/telescope](http://training.lan:8686/telescope)

### phpMyAdmin

To access the database please use the following link.

[http://training.lan:9999](http://training.lan:9999)

Username: user
Password: password

### MailHog

To access the mail server please use the following link.

[http://training.lan:8025](http://training.lan:8025)

Or to get the messages in JSON format.

[http://training.lan:8025/api/v2/messages](http://training.lan:8025/api/v2/messages)

## Testing

Run the following commands from the framework root directory (/site).

### Unit testing
``./vendor/bin/phpunit``

### Functional testing
``php artisan dusk``

# Error tracker

[https://www.bugsnag.com](https://www.bugsnag.com)