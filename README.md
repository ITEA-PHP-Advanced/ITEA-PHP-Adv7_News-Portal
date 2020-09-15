# News Portal

[![Build Status](https://travis-ci.org/ITEA-PHP-Advanced/ITEA-PHP-Adv7_News-Portal.svg?branch=dev)](https://travis-ci.org/ITEA-PHP-Advanced/ITEA-PHP-Adv7_News-Portal)

## Installation

1. Clone repository

    ```sh
    $ git clone git@github.com:ITEA-PHP-Advanced/ITEA-PHP-Adv7_News-Portal.git
    ```
   
2. Install dependencies

    ```sh
    $ composer install
    ```

3. Configure database connection

    ```sh
    $ mv .env .env.local
    ```
   
4. Create and run docker containers

    ```sh
    $ docker-compose up -d --build
    ```
   
4. Create a database and run migrations

    ```sh
    $ docker-compose exec php-fpm bash
    $ ./bin/console doctrine:database:create
    $ ./bin/console doctrine:migrations:migrate
    ```   

## Code style fixer

To check the code style just run the following command


```bash
$ composer cs-check
```


to fix the code style run next command

```bash
$ composer cs-fix
```

Tests
-----

To run unit tests just run the following command

```bash
$ docker-compose exec php-fpm ./bin/phpunit
```
