FROM php:8.1-fpm-alpine

RUN apk add --no-cache coreutils
#    zip \
#    libzip-dev \
#    coreutils \
#    freetype-dev \
#    libjpeg-turbo-dev \
#    libjpeg-turbo \
#    libpng-dev \
#    libzip-dev \
#    jpeg-dev \
#    icu-dev \
#    libgcrypt-dev \
#    oniguruma-dev


#RUN #docker-php-ext-configure gd --with-freetype --with-jpeg

RUN docker-php-ext-install pdo_mysql
#    iconv
#    zip \
#    intl \
#    gd \
#    opcache \
#    mbstring \
#    curl \

#RUN #docker-php-ext-enable intl

RUN rm -rf /tmp/*

WORKDIR /var/www
EXPOSE 9000
