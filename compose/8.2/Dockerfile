# Use a specific version of PHP
FROM php:8.2-fpm

# Set UID and GID as environment variables
ARG UID
ARG GID
ENV UID=${UID} GID=${GID}

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim \
    optipng \
    pngquant \
    gifsicle \
    vim \
    unzip \
    git \
    curl \
    libonig-dev \
    libzip-dev \
    libgd-dev \
    autoconf \
    pkg-config \
    libssl-dev \
    libzip-dev \
    zlib1g-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install  \
    pdo_mysql \
    mbstring \
    zip \
    exif \
    pcntl \
    gd

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Add laravel user and group
RUN groupadd -g ${GID} laravel && useradd -u ${UID} -g laravel -ms /bin/bash laravel

# Change ownership
RUN chown -R laravel:laravel /var/www

# Copy php configuration file
COPY ./rootfs/etc/php82/local.ini /usr/local/etc/php/conf.d/local.ini

# Expose port 9000 and start php-fpm server
EXPOSE 9000

CMD ["php-fpm"]
