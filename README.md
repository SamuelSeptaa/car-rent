Installation step

-   Clone this project to your local repository.
-   On the command line, type
-   `composer update`
-   Setup your .env file like database etc.
-   You need to fill this lines of code to your .env

-   Generate key in CMD with `php artisan key:generate`
-   Generate the database tables `php artisan migrate:fresh`
-   Insert the dummy data to database using `php artisan db:seed --class=DatabaseSeeder`
-   You are good to go, now type `php artisan serve`

> **_NOTE:_** My local dev environment is using PHP 8.0.28.
