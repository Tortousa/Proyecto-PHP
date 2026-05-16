#!/bin/bash
set -e

# Cache config, routes and views for production performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Recrear BD limpia y resembrar en cada deploy
php artisan migrate:fresh --seed --force --no-interaction


# Create the public/storage symlink (safe to run multiple times)
php artisan storage:link --force

exec "$@"
