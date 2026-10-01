FROM php:8.2-fpm

# Install nginx
RUN apt-get update && apt-get install -y nginx && rm -rf /var/lib/apt/lists/*

# Install PDO MySQL and MySQLi extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copy application files
COPY . /var/www/html/

# Create required directories and set permissions
RUN mkdir -p /var/www/html/img /var/www/html/document /var/www/html/img/part \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/img /var/www/html/document

# Copy nginx config
COPY nginx.conf /etc/nginx/conf.d/default.conf

# Copy entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Expose HTTP port
EXPOSE 8080

# Start both PHP-FPM and Nginx
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]

