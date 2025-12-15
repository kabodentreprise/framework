#!/usr/bin/env bash
set -e

echo "Deploying application..."

echo "1. Installing dependencies..."
composer install --no-dev --optimize-autoloader

echo "2. Compiling assets..."
npm install
npm run build

echo "3. Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "4. Running migrations..."
php artisan migrate --force

echo "Deployment finished!"
