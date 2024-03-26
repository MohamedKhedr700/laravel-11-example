FROM php:8.2.4-fpm-alpine

RUN apk update && apk upgrade

# Essentials
RUN echo "UTC" > /etc/timezone

RUN apk add  \
    git \
    zip \
    unzip \
    curl \
    sqlite \
    nginx \
    supervisor \
    nodejs \
    npm

RUN apk add \
    php81-gd \
    php81-imap \
    php81-redis \
    php81-cgi \
    php81-bcmath \
    php81-mysqli \
    php81-zlib \
    php81-curl \
    php81-zip \
    php81-mbstring \
    php81-iconv \
    gmp-dev

# dependencies required for running "phpize"
# these get automatically installed and removed by "docker-php-ext-*" (unless they're already installed)
ENV PHPIZE_DEPS \
    autoconf \
    dpkg-dev \
    dpkg \
    file \
    g++ \
    gcc \
    libc-dev \
    make \
    pkgconf \
    re2c \
    zlib \
    wget

# Install packages
RUN set -eux; \
    # Packages needed only for build
    apk add --virtual .build-deps \
        $PHPIZE_DEPS

RUN apk add --no-cache linux-headers

# Packages to install
RUN apk add  \
    curl \
    freetype-dev \
    gettext-dev \
    libmcrypt-dev \
    icu-dev \
    libpng \
    libpng-dev \
    libressl-dev \
    libtool \
    libxml2-dev \
    libzip-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    freetype-dev \
    oniguruma-dev \
    unzip

# pecl PHP extensions
RUN pecl install \
    # imagick-3.4.4 \
    mongodb \
    redis

# Configure PHP extensions
RUN docker-php-ext-configure \
        gd --enable-gd --with-freetype --with-jpeg --with-webp

# Install PHP extensions
RUN docker-php-ext-install \
    bcmath \
    bz2 \
    exif \
    ftp \
    gettext \
    gd \
    gmp \
    mbstring \
    opcache \
    pdo \
    pdo_mysql \
    shmop \
    sockets \
    sysvmsg \
    sysvsem \
    sysvshm \
    zip \
    intl \
    soap

# Enable PHP extensions
RUN docker-php-ext-enable \
    # imagick \
    mongodb \
    redis

RUN \
    # Remove the build dependencies
    apk del .build-deps && \
    # Clean out directories that don't need to be part of the image
    rm -rf /tmp/* /var/tmp/*

# Fix work iconv library with alphine
ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so

# Installing bash
RUN apk add bash
RUN sed -i 's/bin\/ash/bin\/bash/g' /etc/passwd

# Installing composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php
RUN php composer-setup.php --install-dir=/usr/local/bin --filename=composer
RUN rm -rf composer-setup.php

# Configure supervisor
RUN mkdir -p /etc/supervisor.d/
RUN touch /run/supervisord.sock
#COPY ./rootfs/etc/supervisord/supervisord.ini /etc/supervisor.d/supervisord.ini

# Cron Config
#COPY ./rootfs/e/tc/crontab /etc/crontabs/root

# Config PHP
#COPY ./rootfs/etc/php/local.ini /usr/local/etc/php/php.ini

# Install Laravel Echo Server
#RUN npm install -g laravel-echo-server

# Nginx configuration
RUN mkdir -p /run/nginx/
RUN touch /run/nginx/nginx.pid

#COPY ./rootfs/etc/nginx/nginx.conf /etc/nginx/nginx.conf
#COPY rootfs/etc/nginx/conf.d/default.conf /etc/nginx/http.d/default.conf

RUN ln -sf /dev/stdout /var/log/nginx/access.log
RUN ln -sf /dev/stderr /var/log/nginx/error.log

USER root
WORKDIR /var/www/html

EXPOSE 80

CMD ["supervisord", "-c", "/etc/supervisor.d/supervisord.ini"]
