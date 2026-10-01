#!/bin/sh
set -e

PORT="${PORT:-8080}"

# Substitute PORT in nginx config
sed -i "s/\${PORT:-8080}/$PORT/g" /etc/nginx/conf.d/default.conf

# Start PHP-FPM in background
php-fpm -D

# Start nginx in foreground
exec nginx -g "daemon off;"
