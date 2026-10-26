FROM php:8.5.12-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends libzip-dev unzip git \
    && docker-php-ext-install mysqli zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY php.ini /usr/local/etc/php/conf.d/custom.ini
COPY deny-dotfiles.conf /etc/apache2/conf-available/deny-dotfiles.conf
RUN a2enmod remoteip && a2enconf deny-dotfiles
