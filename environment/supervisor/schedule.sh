#!/bin/sh
cd /var/www/html 
php artisan schedule:run >> /dev/null 2>&1
