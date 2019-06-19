# Training project

## Docker installation

A working [Docker](https://docs.docker.com/engine/installation/) installation is mandatory.

## Docker environment variables file

Please make sure to copy & rename the **example.env** file to **.env**.

``cp example.env .env``

You can replace the values if needed, but the default ones should work.

## Edit hosts file

Edit hosts file to point **training.lan** to you docker host.

## Environment installation & configuration

Run the following docker commands from the project root directory.

Build & run all the containers for this project

``docker-compose up -d``

Update the Laravel .env file

``docker exec train-app cp .env.example .env``

Update the application key

``docker exec train-app cp php artisan key:generate``

Install php dependencies

``docker exec train-app composer install``

Install js dependencies

``docker exec train-app npm install``

``docker exec train-app npm run dev``

Run migrations

``docker exec train-app php artisan migrate --no-interaction --force``

Seeding first user

``docker exec train-app php artisan db:seed`` 

This is only needed when you launch the project for the first time. After that you can simply use the following command from the project root directory.

``docker-compose up -d``

## Stop docker containers

Terminate execution to stop the containers OR use the following command from the project root directory.

``docker-compose stop``

You can check if the containers are indeed stopped with the following command (output should be empty).

``docker ps``

## Frontends

To access the main application please use the following link.

[http://training.lan:8686](http://training.lan:8686)

To access the administration please use the following link.

[http://training.lan:8686/admin](http://training.lan:8686/admin)

login: user@example.com
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

[http://training.lan:8025](http://impact.lan:8025)

Or to get the messages in JSON format.

[http://training.lan:8025/api/v2/messages](http://impact.lan:8025/api/v2/messages)
