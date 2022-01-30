## About

Project build on top of Laravel with Docker that comes with:
- [x] PHP 8.0
- [x] MariaDB 10.6 (can be swapped by MySQL or whatever needed)
- [x] Nginx
- [x] Redis

## Project setup

- Start containers:
     ```sh
    $ docker-compose up -d
    ```
- Stop & remove containers:
    ```sh
    $ docker-compose down
    ```
- Copy .env.example to .env
- Installing dependencies:
    ```sh
    $ docker-compose exec app composer install
    ```
- Run migrations:
    ```sh
    $ docker-compose exec app php artisan migrate
    ```

### How to access

- Accessing the system: [localhost:8080](http://localhost:8080/)
