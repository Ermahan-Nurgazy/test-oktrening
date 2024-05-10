# Test task for Oktrening



## Getting started

These instructions will give you a copy of the project up and running on your local machine for development and testing purposes.

## Installation

A step by step series of examples that tell you how to get a development environment running

1. Clone this repo

```
git clone https://github.com/Ermahan-Nurgazy/test-oktrening
```

2. Build the image

```
docker-compose build
```
3. Run the image's

```
docker-compose up -d
```
4. Run following commands inside an existing container

```
docker exec -it php bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan jwt:secret
```

## Postman documentation

Use this Postman collection to interact with the API endpoints

-  [Link to collection](https://documenter.getpostman.com/view/19202302/2sA3JM5g1y#83717e43-8264-4d62-bc27-c07d228c7e4d)