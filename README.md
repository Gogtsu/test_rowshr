# Docker installation
 - run `docker-compose up -d --build`
 - after the build run `docker-compose exec php chown -R laravel:laravel /var/www/html/storage /var/www/html/bootstrap/cache` to give laravel user group access to these folders
# Installation
 I already have laravel installer on my Windows machine. 
 - I ran the command `laravel new test_rowshr`
 - I'll be using Wamp server with a vhost for now for faster development. 
 - I will be using the latest version of Laravel 11.x (11.9 as in composer.json) with PHP 8.3.6
 - Enable the required php extensions from [the documentation](https://laravel.com/docs/11.x/deployment#server-requirements)
 - Create a mysql database. It is good practice (if not imperative) to also create a user for the database, but in my case I will leave it as root since it is just a test and will most likely not be deployed anywhere
# Task 1
 - I start by running the following commands to generate the 3 models and migrations using laravel stubs
 - `php artisan make:model -m Employee`
 - `php artisan make:model -m Project`
 - `php artisan make:model -m EmployeeProject`
 
 - I deleted the default laravel migrations and the User model, since we won't be dealing with those
 - I filled in the base migrations logic for employees, projects and empoyee_projects
 - `php artisan migrate`
 - Now I get an error that laravel cannot find the `sessions` table. This is because the driver for sessions is set to database, so we can adjust that in the `config.php` or `.env`. Let's do it in .env, change the `SESSION_DRIVER` var to basic `file`
 - I added the model relations for Project and Employee, `withPivot('role')` because, if not specified only the keys will be selected.
 > I should make a repository for this test at this point. I will use the Github Desktop app for simplicity
 - I think now it's a good time to make some seeds so we can test if the relations are working as intended. This will jump to the **task 2.1**, but I'll come back to the other functions in a moment
 - `php artisan make:seed EmployeeSeeder` and `php artisan make:factory EmployeeFactory`
 - `php artisan make:seed ProjectSeeder` and `php artisan make:factory ProjectFactory`
 - the factories are pretty basic, only `name` and `title`
 - Since Employees can have different roles on the Projects and not themselves, I will attach them from the Project Seeder. I will use the function `each()` to do that. I will also add the timestamps to make the db 'heavier' and have uniformity with irl examples
 - Now I can test the relations with tinker, firing `App\Models\Employee::first()->projects()->get()` and `App\Models\Project::first()->employees()->get()` returns data and works fine :joy:
 - Now for the extra functions in **task 1.4** and **task 1.5**
 - Since this is a test I will write an additional function for the first point of task 1.4, but I could just call the Eloquest relation `employees` and `get()` method or call `$project->employees` as attribute. Let's just map the `pivot->role` attribute to the employee itself as `role`
 - For counting I will have to use `DB::raw` since role is not a Model to use `withCount`, also invoke the relation, not the collection and return as `$role => $count`
 - For Employee's projects function I will copy paste the `getEmployees` funciton from Project since from a functional perspective is the same and adjust the semantics

# Task 2
 - actually **task 2.2** since 2.1 is already implemented for testing purposes in Task 1.
 - create 2 controllers `php artisan make:controller ProjectController` and `php artisan make:controller EmployeeController`
 - for Project listing **task 2.2** I will simply use the `with` function that already specifies `withPivot('role')`
 - for the filtering of **task 2.3** I will use `whereHas` and a $role parameter
 - add the Routes to `web.php`
 - Before moving to **task 3** I would like to start with the **bonus task** with Vue.Js since for **task 3** I would have to use `web.php` instead of `api.php`. Also I want to have an interface for these functions myself.

# Bonus Task
 - I will not separate the frontend and backend from the root directory.
 - I will use Laravel's default module builder, vite and install `@vitejs/plugin-vue`
 - `php artisan install:api` and delete the `personal_access_token` migration since there is no authentication
 - Now that vue is working I will install `vue-router` and setup the standard `App.vue` with `router.js`
 - I will create a folter for employees components and one for project components
 - There isn't much to talk about the vue part, it's just coding. Oh and I used tailwind since it comes preinstalled and it's my fav css framework. You should see the frontend for yourself
 - I tried to include all the functions, but in such a way that I can use relations and not flood the query requests for the db. For example the count of roles is done after clicking a project

# Task 3 
 - 1. likely the most complex function so far for the backend. Most Notably I used the type paramenter with automatically converts from the id to the model object, and the role as a request parameter since we are using it as string 
 - 2. basic `delete request`
 - 3. using `detach` method from laravel

# Task 4
 - read Optimisation.md