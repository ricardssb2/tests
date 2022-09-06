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

