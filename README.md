# Reparation-CRM

Reparation-CRM is a web application designed for repair shop owners specializing in smartphones, tablets, and computers. It enables them to log customer devices, track repairs online, and generate printable receipts. The platform features a dedicated customer interface and a more complete dashboard for employees and managers.

## Steps to deploy locally on your PC/Mac

### Without docker

- install php8.3
- install MySQL
- install Apache  
I recommend doing the first three steps by installing [AMPPS](https://ampps.com/) (for example)
- Clone this repository: ```git clone git@github.com:guenoel/reparationcrm.git```
- configure .env file and place it at the root of the project: [Here an example of .env file](./.env.example)
- subscribe to the rapidapi host: [mobile-phone-specs-database](https://rapidapi.com/makingdatameaningful/api/mobile-phone-specs-database) and paste the key in the .env file
- ```install composer```
- ```php artisan key:generate```
- ```php artisan serve```
- ```install npm```
- ```npm run dev```

You can know access the web site on http://localhost:8000/ (by default)

### With docker

Alternatively, if you are using Laravel Sail (a built-in solution for running Laravel projects using Docker), you can follow these steps: (not tested)

- Install Docker Desktop: Ensure Docker Desktop is installed on your machine.
- Clone the Project: Use Git to clone the Laravel project.
- Start Laravel Sail: Navigate to the project directory and run ./vendor/bin/sail up. This command will start the application's Docker containers.
- Access the Application: Once the containers are up, you can access the application in your web browser at http://localhost.

This app is made with the PHP Framework:
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>
