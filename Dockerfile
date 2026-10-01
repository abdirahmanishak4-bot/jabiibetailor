FROM php:8.2-apache

# Disable all conflicting Apache MPM modules to prevent "More than one MPM loaded" error
RUN a2dismod mpm_event mpm_worker mpm_prefork || true && \
    a2enmod mpm_prefork

# Install PDO MySQL and MySQLi extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy application files to Apache root
COPY . /var/www/html/

# Create required upload directories and set permissions
RUN mkdir -p /var/www/html/img /var/www/html/document /var/www/html/img/part \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/img /var/www/html/document

# Expose default port
EXPOSE 80

# Configure Apache port dynamically at runtime using Railway $PORT and start Apache
CMD sh -c "sed -i \"s/Listen 80/Listen \${PORT:-80}/g\" /etc/apache2/ports.conf && sed -i \"s/<VirtualHost \*:80>/<VirtualHost \*:\${PORT:-80}>/g\" /etc/apache2/sites-available/000-default.conf && apache2-foreground"

