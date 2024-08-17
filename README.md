
## About Project

Realisation of a test task for a Middle+ PHP developer. Task is this:

1) Authorization of employees in the system
2) VIEW UPDATE DELETE operations with clients
3) Employee can UPDATE and DELETE clients after confirmation sms or telegram or email code

**Used Laravel 11, PHP 8.3, Livewire 3.5 + Laravel Debugbar 3.13**

## Installation

- run composer install
- npm install
- npm run build
- add database
- add .env and configure
- php artisan key:generate
- php artisan migrate --seed
- php artisan serve

## Usage of confirmation code

To be able to confirm the sent code, you need to change .env APP_DEBUG=true and check tab Messages in Debugbar.