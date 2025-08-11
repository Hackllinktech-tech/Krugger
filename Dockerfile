FROM php:8.2-apache

# Install mysqli extension for MySQL database connectivity
RUN docker-php-ext-install mysqli

# Enable Apache mod_rewrite (optional, enables custom URL routing)
RUN a2enmod rewrite

# Copy project files into the Apache document root
COPY . /var/www/html/

# Install Composer globally (optional, only if you use composer.json)
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

# Install Composer dependencies if composer.json exists
WORKDIR /var/www/html
RUN if [ -f composer.json ]; then composer install; fi

# Set proper permissions for Apache (optional, improves security and access)
RUN chown -R www-data:www-data /var/www/html

# Expose port 80 for Apache web server
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
