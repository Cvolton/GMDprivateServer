FROM php:7.3-apache
RUN docker-php-ext-install mysqli pdo_mysql
COPY . /var/www/html/
