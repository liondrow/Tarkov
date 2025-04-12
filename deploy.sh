#!/bin/bash

echo "=== Starting deploy ==="

cd /var/www/tarkov-back || exit

echo "Pulling latest changes from master..."
git pull origin master

echo "Installing composer dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader

echo "Running migrations..."
php bin/console doctrine:migrations:migrate --no-interaction

echo "Clearing cache..."
php bin/console cache:clear

echo "Setting permissions..."
chmod -R 775 var
chmod -R 775 vendor

echo "Restarting PHP-FPM..."
sudo systemctl reload php8.1-fpm

echo "Deploy finished!"
