# Welcome on Chipstorm Support Ticketing

## Project informations
Project name: Chipstorm Support Ticketing
PHP version: 7.4
Laravel version: 8.0

## Installation
- Clone the project : git clone git@github.com:Rokem-prog/chipstorm_support_ticket.git
- Create a database and an user
- Copy __.env.example__ file to __.env__ and edit with database credentials and mail credentials
- Run __composer install__
- Run __php artisan key:generate__
- Run __php artisan migrate --seed__ (it has some seeded data for your testing)
- That's it: launch the main URL 
- If you want to login, click `Login` on top-right and use credentials __admin@admin.com__ - __password__ 
- Agent's credentials are __agent1@agent1.com__ - __password__ 

## Launch the project on local
- Start xampp (apache and mysql) : ./xampp start
- Go in the project directory : cd chipstorm_support_ticket
- Run the project : php artisan serve
- Go to the url : http://127.0.0.1:8000

## To commit your changes
- "git add ." to add all your changes, or "git add <file>" to add a specific file
- "git commit -m "your message"" to commit your changes
- "git push origin master" to push your changes on the remote repository

## Some elements to know
- all the routes are in __routes/web.php__ -> this contains all the routes of the project
- all the controllers are in __app/Http/Controllers__ 
- all the views are in __resources/views__ -> this contains all the html files
- all the models are in __app/Models__
- all the migrations are in __database/migrations__
- all the seeders are in __database/seeders__
- all the mails are in __app/Notifications__

## To create a new controller
- "php artisan make:controller <controller_name>"
- "php artisan make:controller <controller_name> --resource" to create a controller with all the methods (index, create, store, show, edit, update, destroy)

## To create a new model
- "php artisan make:model <model_name>"
- "php artisan make:model <model_name> -m" to create a model and a migration
- "php artisan make:model <model_name> -m -s" to create a model, a migration and a seeder

## To create a new migration
- "php artisan make:migration <migration_name>"
- "php artisan make:migration <migration_name> --create=<table_name>" to create a migration for a specific table

## To create a new seeder
- "php artisan make:seeder <seeder_name>"
- "php artisan make:seeder <seeder_name> --model=<model_name>" to create a seeder for a specific model



