# Welcome on Chipstorm Support Ticketing

## Project informations
Project name: Chipstorm Support Ticketing
PHP version: 7.4
Laravel version: 8.0

## Installation
- Clone the project : git clone https://github.com/renatevv/internship-portugal.git
- Create a database and an user
We used MySQL Workbench for local testing, you need to create a schema the same name as `DB_DATABASE` in .env configuration
- Copy __.env.example__ file to __.env__ and edit with database credentials and mail credentials
- Run __composer install__
- Run __php artisan key:generate__
- Run __php artisan migrate --seed__ (it has some seeded data for your testing)
- That's it: launch the main URL 
- If you want to login, click `Login` on top-right and use credentials __admin@admin.com__ - __password__ 
- Agent's credentials are __agent1@agent1.com__ - __password__ 

For mail credentials we used:

- MAIL_MAILER=smtp
- MAIL_HOST=smtp.gmail.com
- MAIL_PORT=587
- MAIL_USERNAME="gmail here"
- MAIL_PASSWORD="app password 2fa required"
- MAIL_ENCRYPTION=tls
- MAIL_FROM_ADDRESS="gmail here"
- MAIL_FROM_NAME="${APP_NAME}"

Also requires database credentials in resources>views>db_connection>connection.php
When testing the project on the local environment we used a new gmail account, if you want to set that up:
- create new gmail account
- enable 2 factor authorization
- set up an app password, you have to use this in .env



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



# Some ideas to improve the project
- Try to find how to auto refresh pages
- The function to send a mail weekly is done but :
    - Schedule is not working
    - The design of the mail is not done
- Make popups at ticket arriving in dashboard
- Change app name in config/app.php
- Change the design of the project
- Change the way mails are designed (from notifications to blade files) -> https://laravel.com/docs/8.x/mail#generating-mailables

# Additional tasks 
- Registration form should include the ability to register a company and the registration should be validated by admins. The validations are sent via email and an admin, only after relating the end user to his company name
can click on the link to where the user can be validated, email is also sent to the company user.

- Change the dashboard to:
    - the author email is not necessary, should be replaced with company name instead
    - the buttons for the tickets should be minimized and be replaced with icons
    - add a fast way to assign a technician to a ticket 
    (the select was added to the table but the functionality was not finished)
    - the tickets should have icons by which you recognize the ticket type
    - the tickets should have colors changed depending on what type of ticket it is
    - the priority of the tickets can be changed to include icons (e.g stars)
    - the user to which the tickets are assigned to can be identified by profile pictures
    - the dashboard should prioritize tickets that have a high priority and are pending. (Pending -> in progress -> open)

- Include a new type of user that can see all the company's employee tickets and data regarding the tickets
- Change the agent to be named IT technician

- Include graphs that show more details about tickets like:
    - admins can see details about the technicians (how many tickets they've done, what kind of tickets, what the progress of those tickets are, etc.)
 
- Add a way to add a description and title to images uploaded for tickets.

- Should have 4 types of group user profiles:
    - IT Administrators -  Must access to everything, able to set and config the tool
    - IT Users (technicians) – Must be able only to use the tickets workflow
    - Customer Users (End users) – Must be able to raise new tickets and access to the dashboard to see all the tickets send
    - Customer Administrators (Team Leaders, CEO’s ) - Must be able to raise new tickets and access to ALL the tickets send by Company users, access to the  dashboard to see all the tickets stats

- Build new set of Stats Graphics

