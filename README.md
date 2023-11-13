# Payment System
 System for deposits and money transfers

## Getting Started
1. If not already done, [install Docker](https://docs.docker.com/install/)
2. If not already done, [install Docker Compose]
3. Clone the repository
4. Copy .env.example to .env
6. Run `docker compose up --build -d`
9. Done.

## API
    . Documentation link: https://documenter.getpostman.com/view/9985162/2s9YXk4MWf

## Observation
    Execute commands in container PHP (if necessary): 
        . Create Database: `php artisan migrate`;
        . Drop and Clear Database: `php artisan migrate:fresh`;
        . Execute Seeder: `php artisan db:seed`;
        . Execute unit and integration tests: `php artisan migrate:fresh --env=testing && php artisan db:seed --env=testing && php artisan test`.
        . Init Messenger: `php artisan queue:work --queue=transfer,deposit,notification,deadLetter`