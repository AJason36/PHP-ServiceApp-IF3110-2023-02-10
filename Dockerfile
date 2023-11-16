FROM php:8.0-apache
WORKDIR /var/www/html

# PHP extension and Apache configuration
RUN docker-php-ext-install mysqli
RUN a2enmod rewrite
RUN apt-get -y update ; \
    apt-get -y upgrade ; \
    apt-get -y install ffmpeg ; \