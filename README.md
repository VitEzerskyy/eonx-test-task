test-project EONX
==============

# Installation

First, clone this repository:

```bash
git clone https://github.com/VitEzerskyy/eonx-test-task.git
```

Do not forget to add `eonx.localhost` in your `/etc/hosts` file.

Then, run:

```bash
docker-compose up -d
```
Inside the php-fpm container execute:
```bash
composer install
```
Then execute:
```bash
bin/console doctrine:migrations:migrate -n
```
You are done, you can visit your Symfony application on the following URL: `http://eonx.localhost`)

Api doc: `http://eonx.localhost/api`

First, import data from 3d party API by `POST /customers/create`
Then you can get customers from Db:

`GET /customers`

`GET /customers/{id}`


# Containers

Here are the `docker-compose` built images:

* `db`: This is the MySQL database container (can be changed to postgresql or whatever in `docker-compose.yml` file),
* `php`: This is the PHP-FPM container including the application volume mounted on,
* `nginx`: This is the Nginx webserver container in which php volumes are mounted too,

# Tests
```bash
vendor/bin/phpunit tests/
```

# Improvements

In full version of application can be improved:

* add pagination to `/customers` endpoint
* add functional tests to all endpoints (to check correct behaviour of endpoints) (https://symfony.com/doc/current/testing.html#application-tests)