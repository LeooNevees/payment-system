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

## Used Technologies
    . PHP 8.1;
    . Laravel 10;
    . Mysql;
    . Github;
    . Pest (PHP Unit);
    . RabbitMQ;
    . Docker/Docker-compose;
    . Postman;

## Access system
    . Link: ec2-3-145-17-177.us-east-2.compute.amazonaws.com

## Flow:
    . Relationship Diagram: https://app.diagrams.net/#G1_daFnBq4S9SpgCiSuI9YhnV35Wp9q16G

    . Add User: https://app.diagrams.net/#G14Gpw-BFZbXaoUUYvj1We1BZbe0I0rUew

    . Transfer: https://app.diagrams.net/#G1I6eQ2O5PyksLnM42hsxuc1Lo02LoLjz0

    . Deposit: https://app.diagrams.net/#G10pUSrbUcHpD7G9V2PSA5851cf2cZBTVQ

    . Notification and Dead Letter: https://app.diagrams.net/#G1e_w3yAG3sokBXCYg8r6yH1Uqf-kCliSi