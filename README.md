# Insurance API - Local Setup Guide

## Prerequisites
Ensure you have the following installed:
- PHP (>= 8.x)
- Composer
- MySQL
- Laravel 

## 1. Clone the Repository
```sh
git clone https://github.com/cybernerdie/insurance-api.git
cd insurance-api
```

## 2. Install Dependencies
Run the following command to install PHP and Laravel dependencies:
```sh
composer install
```

## 3. Configure Environment
Copy the example `.env` file and update it with your local setup details:
```sh
cp .env.example .env
```
Then, update these keys in `.env`:
```env
APP_NAME="Insurance API"
APP_URL=http://localhost
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=insurance_db
DB_USERNAME=root
DB_PASSWORD=
```

## 4. Generate Application Key
```sh
php artisan key:generate
```

## 5. Run Migrations & Seed Database
```sh
php artisan migrate --seed
```
This will create the database tables and seed default records.

## 6. Install & Setup Laravel Passport
```sh
php artisan passport:install
```
This will generate Passport keys for API authentication

## 7. Start the Development Server
```sh
php artisan serve
```
Your API should now be running at `http://127.0.0.1:8000`.

## 8. Running Tests
```sh
php artisan test
```
or
```sh
vendor/bin/pest
```

## 9. API Endpoints & Documentation
You can find the API documentation here:
[Postman Documentation](https://documenter.getpostman.com/view/14188615/2sAYdcrXwd)
