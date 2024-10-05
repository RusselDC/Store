# Use an official PHP runtime as a parent image
FROM php:8.3-apache

# Install dependencies for PHP extensions and PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip

# Set the working directory
WORKDIR /var/www/html

# Copy the contents of your project into the container
COPY . /var/www/html/

# Change the Apache document root to the public directory
RUN echo "DocumentRoot /var/www/html/public" > /etc/apache2/sites-available/000-default.conf

# Enable the Apache rewrite module
RUN a2enmod rewrite

# Expose the port the app runs on
EXPOSE 80
