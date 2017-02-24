#!/bin/bash

echo 'Clone Ionic Template -> template Folder'
git clone https://github.com/socheatsok78/SAGE-Template.git template && \
cd template && \
npm install && \
ionic state restore

echo 'Prepare Laravel App for SAGE-Engine'
cd .. && \
cd engine && \
composer install && \
composer update && \
npm install && \
npm update && \
cp .env.example .env && \
php artisan key:generate && \
php artisan serve
