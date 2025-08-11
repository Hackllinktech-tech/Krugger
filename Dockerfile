# Use the official PHP image with Apache
FROM php:8.2-apache

# Copy project files to the Apache document root
COPY . /var/www/html/

# Enable Apache mod_rewrite (optional, if you use it)
RUN a2enmod rewrite

# Install Composer globally (optional, if you use composer.json)
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

# If you use composer.json, install dependencies
WORKDIR /var/www/html
RUN if [ -f composer.json ]; then composer install; fi

# Expose port 80 for Apache
EXPOSE 80
