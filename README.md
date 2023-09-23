
# Installation

`git clone https://github.com/nourpups/payme-laravel-integration.git`

`cd payme-laravel-integration`

`docker compose up -d`

`docker exec -it docker_guru_app bash`

`composer install`

#### rename .env.example to .env

`php artisan key:generate`


## Set database settings

`DB_DATABASE=db`

`DB_DATABASE=docker_guru`

`DB_USERNAME=root`

`DB_PASSWORD=root`

## Migrations & Seeders

`php artisan migrate`

`php artisan db:seed`

## Login credentials
- Email: shuniyam@eploma.exx
- Password: nouracea
  Also displayed on login page.

## Final! Running on local server

You can now access the server at [http://localhost:8876](http://localhost:8876)

