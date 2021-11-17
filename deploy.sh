#!/bin/sh
set -e

echo "Deploying application ..."

# Enter maintenance mode
(php artisan down --message 'The app is being (quickly!) updated. Please try again in a minute.') || true
    # Update codebase
    git fetch origin main
    git pull origin main

    # chmod
    chmod -R 775 storage
    chmod -R ugo+rw storage
# Exit maintenance mode
php artisan up

echo "Application deployed!"
