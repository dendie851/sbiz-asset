FROM php:8.1-apache

# Install and enable mysqli driver
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Copy source code (optional if using volumes, but good for build)
# COPY ./apps /var/www/html/

# Expose port 80
EXPOSE 80
