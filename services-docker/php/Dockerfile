# https://hub.docker.com/_/php
# https://github.com/docker-library/docs/blob/master/php/README.md#supported-tags-and-respective-dockerfile-links

FROM php:7.4-fpm-alpine

RUN apk add composer

# Change the UID and GID of the www-data user to the same values as those of the user on the host
# This works around permissions issues when the webserver must create files, such as the Laravel log
RUN echo http://dl-2.alpinelinux.org/alpine/edge/community/ >> /etc/apk/repositories
RUN apk --no-cache add shadow && usermod -u 1000 www-data && groupmod -g 1000 www-data
RUN chown -R www-data:www-data /var/www/html
RUN docker-php-ext-install pdo pdo_mysql


# GD
#RUN apk add --no-cache libzip-dev && docker-php-ext-configure zip --with-libzip=/usr/include && docker-php-ext-install zip
RUN apk add --no-cache zlib-dev jpeg-dev libpng-dev libwebp-dev libxpm-dev freetype-dev
RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp --with-xpm
RUN docker-php-ext-install -j$(nproc) gd


RUN docker-php-ext-install exif


# Xdebug
RUN apk --no-cache add autoconf g++ make
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

# If changing to a different tag, ensure that the tagged version either supports the UID/GID workaround or has another solution.
