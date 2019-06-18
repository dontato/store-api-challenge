# Store API Challenge

![Laravel logo](https://laravel.com/assets/img/components/logo-laravel.svg)

## About The Project

This project provides an API that allows users to browse a products catalog, filtering results by name and sorting them by popularity or alphabetically by name.

This project features:

- JWT based authentication with [JWT Auth](https://github.com/tymondesigns/jwt-auth)
- Role based and permissions based authorization enforced though policies [Laravel Permission](https://github.com/spatie/laravel-permission)
- Basic searchable models [Laravel Searchable](https://github.com/nicolaslopezj/searchable)
- Automatically generated slugs [Eloquent Sluggable](https://github.com/cviebrock/eloquent-sluggable)

I have also used the following Laravel out of the box features:

- [Eloquent Resources](https://laravel.com/docs/5.8/eloquent-resources)
- [Form Requests](https://laravel.com/docs/5.8/validation#form-request-validation)
- [Events and Listeners](https://laravel.com/docs/5.8/events)
- [Policies](https://laravel.com/docs/5.8/authorization#writing-policies)
- [Notifications](https://laravel.com/docs/5.8/notifications)

##Project setup

First of all, you will need to clone the repository:

    git clone git@github.com:dontato/store-api-challenge.git

## Setup using Docker

Using docker you can run the project with the following command:

    docker-compose up

## Setup the old fashioned way

For this scenario, you will need:

- PHP >= 7.1.3
- BCMath PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- MySQL or any other DB engine

If you do not have already installed composer on your system, you can install it with the following command:

    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php -r "if (hash_file('sha384', 'composer-setup.php') === '48e3236262b34d30969dca3c37281b3b4bbe3221bda826ac6a9a62d6444cdb0dcd0615698a5cbe587c3f0fe57a54d8f5') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
    php composer-setup.php
    php -r "unlink('composer-setup.php');"

You will also need to create a database, if you are using mysql you can do it like so, providing the root password when prompted:

    mysqladmin create -u root -p store_api_challenge

Once these requirements are met, you can copy the `.env.example` file:

    cp .env.example .env

Be sure to set database credentials

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=store_api_challenge
    DB_USERNAME=root
    DB_PASSWORD=root

Once these are set, you can proceed to install the project dependencies

    composer install

After this, you will need to set the app key and the JWT key:

    php artisan key:generate
    php artisan jwt:secret

After this, you will need to migrate the database:

    php artisan migrate --seed

Lastly, if you wish to seed the database with some initial values you can:

    php artisan db:seed --class=UsersTableSeeder
    php artisan db:seed --class=ProductsTableSeeder
    php artisan db:seed --class=LikesTableSeeder

If you do not have [Valet](https://laravel.com/docs/5.8/valet) installed on your system, you can use the command to run the project:

	php artisan serve

And access it through `http://localhost:8080`

## Running Tests

To run tests you will need to setup a `.env.testing` file, heres an example of what it should look like:

    APP_ENV=testing
    APP_KEY=[REPLACE_ME]
    APP_DEBUG=true
    APP_URL=http://store-api-challenge.test

    LOG_CHANNEL=stack

    DB_CONNECTION=sqlite
    DB_DATABASE=/path/to/project/database/test.sqlite

    BROADCAST_DRIVER=log
    CACHE_DRIVER=array
    SESSION_DRIVER=array
    SESSION_LIFETIME=120
    QUEUE_DRIVER=sync
    MAIL_DRIVER=log

    JWT_SECRET=[REPLACE_ME]

You can set the `JWT_SECRET` and `APP_KEY`, with the following command:

    php artisan key:generate --env=testing
    php artisan jwt:secret --env=testing

To run tests you will need to create the `.sqlite` database, like so:

    touch database/test.sqlite

You will also need to migrate the database:

    php artisan migrate --seed --env=testing

Lastly, to run tests do a:

    vendor/bin/phpunit
