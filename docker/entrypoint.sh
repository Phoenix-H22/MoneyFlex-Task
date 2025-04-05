#!/bin/bash

# Run Laravel-specific commands
php artisan key:generate
php artisan migrate --force
php artisan config:cache

# Run the original CMD (php-fpm)
exec "$@"
