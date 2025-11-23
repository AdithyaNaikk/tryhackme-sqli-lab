FROM php:8.2-apache

# Enable Apache mods and install MySQL extension
RUN docker-php-ext-install pdo_mysql mysqli && a2enmod rewrite

# Copy app files
COPY app/ /var/www/html/

# Set working dir
WORKDIR /var/www/html

# Expose port
EXPOSE 80