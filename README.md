# News Portal

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

    ```dotenv
    DATABASE_URL=mysql://<user>:<password>@127.0.0.1:3306/<db_name>
    ```
   
4. Create a database and run migrations

    ```sh
    ./bin/console doctrine:database:create
    ./bin/console doctrine:migrations:migrate
    ```   
   
5. Run local web-server using [Symfony CLI](https://symfony.com/download)

    ```sh
    $ symfony serve
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
$ ./bin/phpunit
```
