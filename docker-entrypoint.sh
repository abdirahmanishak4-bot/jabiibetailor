#!/bin/sh
set -e

# Start PHP-FPM in background
php-fpm -D

# Start nginx with dynamic port configuration
PORT=${PORT:-8080}
export PORT
exec nginx -g "daemon off; worker_processes auto;" -c /etc/nginx/nginx.conf

