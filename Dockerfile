# Shared build stage with common steps for both final images
FROM php:7.3-fpm AS deps

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    mysql-client \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    libzip-dev \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    supervisor \
    cron \
    wget \
    sqlite3

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# install xdebug
RUN pecl install xdebug

# supervisord
RUN mkdir -p /var/log/supervisor
COPY supervisord/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# cronjob
COPY crontab/config /etc/crontabs/root
RUN touch /etc/crontab /etc/cron.*/*

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install php extensions
RUN docker-php-ext-configure zip --with-libzip \
    && docker-php-ext-install zip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl \
    && docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/ \
    && docker-php-ext-install gd

# PHP config
COPY ./php/local.ini /usr/local/etc/php/conf.d/local.ini

# Set working directory
WORKDIR /var/www

ADD . /var/www

RUN chown -R www-data:www-data /var/www

# do not know if this is the best practice
RUN chmod -R 777 /var/www/storage

# Copy all of the code, sadly the composer deps require the code to be
# available so it cannot be cached seperately
COPY . .


# Image using this target will run an instance of the websocket server
FROM deps AS websocket

# Expose the websocket server to other containers on the same network
EXPOSE 6001

# Run artisan with the default entrypoint which is a docker safe php
CMD ["/var/www/artisan","websockets:serve"]

# Image will be used as queue worker
FROM deps AS queueworker

# Image will be used as queue worker
FROM deps AS supervisord
CMD ["/usr/bin/supervisord"]

# Images using this target will run an instance of the app server
FROM deps AS app

# Expose the php-fpm server to other containers on the same network
EXPOSE 9000