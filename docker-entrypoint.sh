#!/bin/bash
set -e

# Cache config, routes and views for production performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run pending migrations automatically on every deploy
php artisan migrate --force --no-interaction

# Create the public/storage symlink (safe to run multiple times)
php artisan storage:link --force

exec "$@"
