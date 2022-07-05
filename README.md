test-project EONX
==============

# Installation

First, clone this repository:

```bash
$ git clone https://github.com/VitEzerskyy/eonx-test-task.git
```

Do not forget to add `eonx.localhost` in your `/etc/hosts` file.

Then, run:

```bash
$ docker-compose up -d
```

You are done, you can visit your Symfony application on the following URL: `http://eonx.localhost`)

_Note :_ you can rebuild all Docker images by running:

```bash
$ docker-compose build
```

# Containers

Here are the `docker-compose` built images:

* `db`: This is the MySQL database container (can be changed to postgresql or whatever in `docker-compose.yml` file),
* `php`: This is the PHP-FPM container including the application volume mounted on,
* `nginx`: This is the Nginx webserver container in which php volumes are mounted too,
