Master:
![ci](https://github.com/unil-lettres/training/workflows/ci/badge.svg?branch=master)
[![CodeFactor](https://www.codefactor.io/repository/github/unil-lettres/training/badge/master)](https://www.codefactor.io/repository/github/unil-lettres/training/overview/master)

Development:
![ci](https://github.com/unil-lettres/training/workflows/ci/badge.svg?branch=development)
[![CodeFactor](https://www.codefactor.io/repository/github/unil-lettres/training/badge/development)](https://www.codefactor.io/repository/github/unil-lettres/training/overview/development)

# Introduction

Development of technical skills in the Faculty of Arts.

A Laravel 9 app with a [Backpack](https://backpackforlaravel.com/) administration.

Backpack is open-core, but we use features from ``backpack\pro`` which is a paid closed-source Backpack add-on. Which means in order to use this application and the ``backpack\pro`` features a [licence](https://backpackforlaravel.com/pricing) is needed.

# Development

## Docker installation

A working [Docker](https://docs.docker.com/engine/install/) installation is mandatory.

## Docker environment file

Please make sure to copy & rename the **example.env** file to **.env**.

``cp example.env .env``

You can replace the values if needed, but the default ones should work.

## Edit hosts file

Edit hosts file to point **training.lan** to your docker host.

## Environment installation & configuration

Run the following docker commands from the project root directory.

Build & run all the containers for this project

``docker-compose up``

Run the setup script. At this point you'll need a ``backpack\pro`` licence and an ``site/auth.json`` file for your [credentials](https://getcomposer.org/doc/articles/authentication-for-private-packages.md#http-basic) to be able to run the setup script.

``docker exec train-app ./setup.sh``

This is only needed when you launch the project for the first time. After that you can simply use the following command from the project root directory.

``docker-compose up -d``

## Frontends

To access the main application please use the following link.

[http://training.lan:8686](http://training.lan:8686)

To access the administration please use the following link.

[http://training.lan:8686/admin](http://training.lan:8686/admin)

+ first-user@example.com / password

### Telescope

To access the debug tool please use the following link.

[http://training.lan:8686/telescope](http://training.lan:8686/telescope)

### phpMyAdmin

To access the database please use the following link.

[http://training.lan:9999](http://training.lan:9999)

+ Server: train-mariadb
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

# Error tracker

[https://www.bugsnag.com](https://www.bugsnag.com)
