#!/bin/bash
cd /var/www/html
chmod 777 ./storage/app
chmod 777 -R ./storage/framework/cache
chmod 777 -R ./storage/framework/sessions
chmod 777 -R ./storage/framework/testing
chmod 777 -R ./storage/framework/views
chmod 777 -R ./storage/logs
chmod 777 ./bootstrap/cache
chmod a+x ./artisan
./artisan key:generate
./artisan storage:link
./artisan migrate
