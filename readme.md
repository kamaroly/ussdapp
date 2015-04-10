# USSD APPS.

### Setup

- Clone repo
- Create your .env file from the example file: `cp .env.testng .env`
- Install composer dependencies: `composer install`
- Create databases by creating the following files:
    - `storage/database.sqlite`
    - `storage/testing.sqlite`
- Run the following commands:
    - `php artisan migrate`
    - `php artisan migrate --database=sqlite_testing`
- Server: run `php -S localhost:8000 -t public`
- Browse to localhost:8000/posts

### To test

Run Codeception, installed via Composer

```
./vendor/bin/codecept run
```

