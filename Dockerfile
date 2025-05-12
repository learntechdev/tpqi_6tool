# Use the official PHP 7.4 image with Apache
FROM php:7.4-apache

# Set working directory
WORKDIR /var/www/html

# Install required packages and PHP extensions
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install zip mysqli pdo pdo_mysql

# Copy custom Apache configuration
COPY apache-config/sites-available/000-default.conf /etc/apache2/sites-available/000-default.conf
# Enable Apache mod_rewrite
RUN a2enmod rewrite


# Copy application files to the container
COPY . /var/www/html

# Set permissions for the application
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expose port 80
EXPOSE 80

# Start Apache server
CMD ["apache2-foreground"]
