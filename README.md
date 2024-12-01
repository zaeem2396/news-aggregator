<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Setup
- Clone this repository.
- Create an .env file, copy the .env-example file into it and run ```php artisan key:generate``` command.
- Run this command to create containers ```docker compose up --build``` (For windows start docker desktop before running this command).
- After the containers are successfully created run this command ```sudo docker compose exec app bash```
- After running this command, run this command to run migrations ```php artisan migrate```
- Run this command to pupulate database ```php artisan seed --class=PopulateArticle ```
- After running this command it'll populate the DB with past 20 days of data or you can add date manually. ```File path=news-aggregator/database/seeders/PopulateArticle.php```
- Install Bruno client using this link https://www.usebruno.com/
- Import news-aggregator from project repo