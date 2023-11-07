# About
Интеграция Payme по протоколу Merchant API с мини фронтендом
#### Frontend (mini-eShop)
- Аутентификация 
- Корзина (данные хранятся в сессии)

# Installation

`git clone https://github.com/nourpups/payme-laravel-integration.git`

`cd payme-laravel-integration`

`docker compose up -d`

`docker compose run --rm composer install`

### Copy .env.example to .env

`docker compose run --rm artisan key:generate`

## Set database settings

`DB_HOST=db`

`DB_DATABASE=payme_db`

`DB_USERNAME=root`

`DB_PASSWORD=root`

## Migrations & Seeders

`docker compose run --rm artisan migrate`

`docker compose run --rm artisan db:seed`

## Login credentials
- Email: shuniyam@eploma.exx
- Password: nouracea

  *Also displayed on login page*.

## Final! Running on local server

`docker compose run --rm npm install`

`docker compose run --rm npm run build`

You can now access the application at [http://localhost:8876](http://localhost:8876)
