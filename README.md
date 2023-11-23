# Carefer

Carefer is a Laravel project for dealing with ticket reservations.

## Installation

-- For deployment Script check (deployemnt.script) file

```bash

composer install
copy .env.example to .env

run php artisan key:generate

php artisan migrate

php artisan db:seed
 
php artisan serve

```

## Usage

```php
# Login
POST /api/login

# return Buses
GET /api/buses

#read Bus
GET /api/buses/{id}

# return Routes
GET /api/routes

#read Route
GET /api/routes/{id}

# return Reservations
GET /api/reservations

#read Reservation
GET /api/reservations/{id}

#Make Reservation
POST /api/reservations

#Update Reservation
PUT /api/reservations/{id}

#Delete Reservation
DELETE /api/reservations/{id}

#Read most-frequent-trip
GET /api/most-frequent-trip

```

## Documentation
 - POSTMAN COLLECTION is included in the project.
 - Also written documentation is auto generated in the path : http://127.0.0.1:8000/docs/

## TESTING
    - php artisan test

