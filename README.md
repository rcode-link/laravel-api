# Simple api app

## Note

JWT package is installed but but is not used since there was problem with
tests. Insted of spending time on figuring out why 3th party plugin is not working
I opted for 1st party auth ootion - laravel Sanctum.

---

this documentation assumes previus knowlage of php, Laravel, and db engine.

App is written in Laravel 11,

ENVIROMENT:
RECCOMENDED: laravel valet or sail
for database use `mysql` or `mariadb`

Setup steps:

-   make copy of `.env.example` and rename it to `.env`
-   change data in `.env` file to corespond to your enviroment.
-   install dependencies
-   generate app key `php artisan key:generate`
-   run migrations
-   run seeds
-   (for valet) open link (folder-name.test)
-   for sail
    -   run `./vendor/bin/sail up` or `sail up` (in case that alias is set)
    -   open http://localhost in your browser
-   (optional) npm install

OpenApi 3.0 documentation is avalable on `/docs/api`

To run tests use command `php artisan test`

### Installing dependencies

** sail **

when using sail its assumed that docker is installed and alias for sail setup

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

** composer (without sail) **

```bash
composer install
```
