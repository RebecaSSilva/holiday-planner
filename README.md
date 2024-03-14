# Holiday Plans Application

Welcome to the Holiday Plans Application! This application allows users to manage and organize holiday plans, including creating, updating, deleting, and generating PDFs for holiday plans.

## Setup Instructions

Follow these steps to set up and run the Holiday Plans Application on your local machine:

### Prerequisites

Before you begin, make sure you have the following installed on your system:

- PHP (>= 8.1)
- Composer
- MySQL or any other compatible database server
- Git

### Installation

1. Clone the repository to your local machine:
   ```bash
git clone https://github.com/RebecaSSilva/holiday-planner.git

cd holiday-planner       

composer install

cp .env.example .env

php artisan key:generate

Configure your database settings in the .env file:

Build and run the Docker containers:

docker-compose build
docker-compose up -d

Migrate the database:

docker-compose run --rm app php artisan migrate

Only if php artisan migrate fail try this

docker-compose run --rm app php artisan migrate

Seed the database (optional):

docker-compose run --rm app php artisan db:seed

PS: You can use this login if run seed: 
login:admin@gmail.com
password:password

To run the PHPUnit tests, execute the following command:

docker-compose run --rm app php artisan test tests/Unit/HolidayPlanApiTest.php


![image](https://github.com/RebecaSSilva/holiday-planner/assets/102828612/be07db8a-c0f9-4220-bae1-d28efcd230fe)
![image](https://github.com/RebecaSSilva/holiday-planner/assets/102828612/1a4191cb-4066-4271-97e0-4a80104d417b)
![image](https://github.com/RebecaSSilva/holiday-planner/assets/102828612/53ccef86-cc11-4cae-82c9-fc93bf4cd65e)
![image](https://github.com/RebecaSSilva/holiday-planner/assets/102828612/bd7b4c8a-745d-4703-80af-c6c033a92cba)
![image](https://github.com/RebecaSSilva/holiday-planner/assets/102828612/3ee53060-4cdb-47c9-b8df-93005269456d)





