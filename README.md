# Project details
This project functions as a backend project developed in Laravel with a PostgreSQL database to generate REST API services that are used by structured frontend projects capable of utilizing them. It also allows images to be stored on the server using base64-encoded images and performs a login that generates a token to validate the REST API services. 

| |Version |
|----------------|-------------------------------|
|Laravel |`8.83.27` |
|PHP |`7.4.33`|
|PostgreSQL |`12`|

## Important note
- The postman_collections file has been added with all the developed REST APIs.

## Instructions
To start this project on a local server, follow the instructions below.

- Clone the project, either with the command git clone `https://github.com/dev-shelvin-batista/backend-laravel-manage-vehicles.git` or using a GitHub graphical tool.
- After cloning the repository, access the downloaded folder with the cd command in the terminal, i.e., `cd backend-laravel-manage-vehicles`, as several commands will be executed there.
- Run the `composer update` command inside the project folder to install the dependencies.
- Change the database connection in Postgresql in the project's .env file. In this file, modify the variables **DB_HOST**, **DB_PORT**, **DB_DATABASE** (`db_laravel_manage_vehicles` was the name assigned in the project), **DB_USERNAME**, and **DB_PASSWORD**. For the technical test, the **pgAdmin** tool was used, and the database was managed with the **DBeaver** tool.
- Change the connection details for sending emails in the project's .env file. In this file, modify the variables **MAIL_HOST**, **MAIL_PORT**, **MAIL_USERNAME**, **MAIL_PASSWORD**, **MAIL_ENCRYPTION**, **MAIL_FROM_ADDRESS**, and **MAIL_FROM_NAME**.
- Generate the database structure using Laravel migrations by running the command `php artisan migrate`.
- After generating the database structure, you must complete the initial data by running the command `php artisan db:seed`.
- Publish the package configuration and generate the secret key: `php artisan vendor:publish --provider="Tymon\JWTAuth\Providers\LaravelServiceProvider"` and `php artisan jwt:secret`
- Run the command `composer dump-autoload` to use the helpers.
- Clear the cache to avoid errors by running the following commands: `php artisan cache:clear` `php artisan route:clear` `php artisan optimize` `php artisan config:clear`
- At this point, the project is ready to be tested. Run it with the command: `php artisan serve`. By default, the URL `http://127.0.0.1:8000` is used to run the REST services.