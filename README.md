# Installation
 I already have laravel installer on my Windows machine. 
 - I ran the command `laravel new test_rowshr`
 - I'll be using Wamp server with a vhost for now for faster development. 
 - Later I will provide a docker-compose. I do not want to install laravel through docker since that requires a composer installation in, what will likely be, a Dockerfile for PHP
 - I will be using the latest version of Laravel 11.x (11.9 as in composer.json) with PHP 8.3.6
 - Enable the required php extensions from https://laravel.com/docs/11.x/deployment#server-requirements
 - Create a mysql database. It is good practice (if not imperative) to also create a user for the database, but in my case I will leave it as root since it is just a test and will most likely not be deployed anywhere
# Task 1
 - I start by running the following commands to generate the 3 models and migrations using laravel stubs
 - `php artisan make:model -m Employee`
 - `php artisan make:model -m Project`
 - `php artisan make:model -m EmployeeProject`
 
 - I deleted the default laravel migrations and the User model, since we won't be dealing with those
 - I filled in the base migrations logic for employees, projects and empoyee_projects
 - `php artisan migrate`
 - Now I get an error that laravel cannot find the `sessions` tablle. This is because the driver for sessions is set to database, so we can adjust that in the `config.php` or `.env`. Let's do it in .env, change the `SESSION_DRIVER` var to basic `file`