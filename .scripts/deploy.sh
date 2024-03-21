#!/bin/bash
set -e

echo "Deployment started ..."

# Pull the latest version of the app
git pull

# Install composer dependencies
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Clear the old cache
php artisan clear-compiled

# Recreate cache
php artisan optimize

# Run database migrations
php artisan migrate --force

# Restart queue service
sudo systemctl restart sfl-calculator-backend-artisan

echo "Deployment finished!"
