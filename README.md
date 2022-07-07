## Installation

Please check the default server requirements of Laravel and make sure all of them are fullfilled with the server we are gonna work.

Clone Repository:
    `git clone git@github.com:jaymin2492/chat_app.git`

 Install all the dependencies using composer
    `composer install`

Clone .env.example file and rename it .env and make the required databse configuration changes in the .env file
    `cp .env.example .env`

Generate Application Keys
    `php artisan key:generate`

Before proceeding to next Step make sure database setup is done and configuration are added to .env.example

Database Migrations
    `php artisan migrate`

Frontend Implementations
    `npm install && npm run dev`

 You are done! Start the Server
    `php artisan serve`

Copy and paste the following URL in browser and enjoy messaging
    `http://127.0.0.1:8000/`

## Dummy Users

Run the database seeder to generate fake users for testing and you're done
    `php artisan db:seed --class=UserSeeder`
## Short Video
`https://drive.google.com/file/d/1bM4kcx5zQhRYC57F0nYUkI4dN-jpS27z/view?usp=drivesdk`
