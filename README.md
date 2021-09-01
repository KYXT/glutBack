## How install app

- Clone app to your server
- Create .env file from .env.example
- Connect your DB in .env
- Run "composer update" command
- Run "php artisan migrate" command
- Run "php artisan passport:install" command
- Run "php artisan db:seed" command if you want create test data
- Enjoy!

## How send api requests
- In Headers set parameter - Content-Language [ru or pl]