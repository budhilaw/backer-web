#!/bin/sh
set -e

echo "Deploying application ..."

# Enter maintenance mode
(php artisan down --message 'The app is being (quickly!) updated. Please try again in a minute.') || true
    # Update codebase
    git fetch origin main
    git pull origin main

    # Chmod
    sudo chmod -R 755 storage bootstrap/cache
# Exit maintenance mode
php artisan up

echo "Application deployed!"
