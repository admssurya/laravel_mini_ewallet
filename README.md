<p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Mini Wallet

This project use Laravel Framework, for server requirements can be found at [documentation](https://laravel.com/docs)

After clone this project, create env file with duplicate .env.example file and rename with .env. For Database this project use MySql so you must create new database.

Environmental Database Configuration:

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=your_databasename
    DB_USERNAME=your_mysql_username
    DB_PASSWORD=your_mysql_password


Install dependency composer:

    ➜  ~ composer install
    
Optional, install NPM:

    ➜  ~ npm install

Run NPM 

    ➜  ~ npm run dev

Database Migration:

    ➜  ~ php artisan migrate
    
Database Seeding:

    ➜  ~ php artisan db:seed
    
Install Passport:

    ➜  ~ php artisan passport:install

For start Local Development Server: 

    ➜  ~ php artisan serve

