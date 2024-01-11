<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


This project is for testing Paypal intergration. It uses Laravel for backed and vue + inertia in frontend. I have included the .env file as it have paypal configuration, so i did it to simplify. 
## INSTALLATION
clone the project, then run the commands below.
1.composer install
2.composer update
3. npm install
4. npm update
5. npm run dev or npm run watch
6.php artisan migrate --seed
7. php artisan serve

## LOGIN CREDENTIALS
username: admin@gmail.com
password: 1234567890

## PAYPAL PAYMENT CREDENIALS
The credential to login when payment process is initiated are the below:
email = sb-ozdfh29237295@business.example.com
password = Ch@mbul1l@

**NB; if after clicking the "submit task" button it does not redirect to paypal, please inspect networks and open the last url.**


