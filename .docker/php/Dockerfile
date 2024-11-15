FROM php:8.3-fpm

WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y \
        zlib1g-dev \
        libzip-dev \
        libicu-dev \
    && docker-php-ext-install -j$(nproc) bcmath zip intl pdo pdo_mysql opcache \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug opcache

COPY php.ini /usr/local/etc/php/php.ini

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER 1
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer