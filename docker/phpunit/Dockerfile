FROM php:8.1-fpm-alpine
RUN docker-php-ext-install pdo_mysql
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer

WORKDIR /var/www
EXPOSE 9000
