FROM php:8.2-apache

# Disable conflicting Apache MPM modules completely
RUN set -eux; \
    a2dismod mpm_event || true; \
    a2dismod mpm_worker || true; \
    a2dismod mpm_prefork || true; \
    a2dismod mpm_itk || true; \
    a2enmod mpm_prefork; \
    a2enmod rewrite

# Install PDO MySQL and MySQLi extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copy application files to Apache root
COPY . /var/www/html/

# Create required upload directories and set permissions
RUN mkdir -p /var/www/html/img /var/www/html/document /var/www/html/img/part \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/img /var/www/html/document

# Clean up Apache MPM modules directory to prevent conflicts
RUN rm -f /etc/apache2/mods-enabled/mpm_*.load /etc/apache2/mods-available/mpm_event.* /etc/apache2/mods-available/mpm_worker.* || true

# Ensure only prefork is enabled
RUN a2enmod mpm_prefork

# Expose default port
EXPOSE 80

# Configure Apache port dynamically at runtime using Railway $PORT and start Apache
CMD sh -c "sed -i \"s/Listen 80/Listen \${PORT:-80}/g\" /etc/apache2/ports.conf && sed -i \"s/<VirtualHost \*:80>/<VirtualHost \*:\${PORT:-80}>/g\" /etc/apache2/sites-available/000-default.conf && apache2-foreground"

