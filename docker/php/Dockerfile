FROM php:8.1-fpm
RUN apt-get update && apt-get install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && pecl install xdebug  \
    && docker-php-ext-enable xdebug

COPY ./docker/php/xdebug.ini /usr/local/etc/php/conf.d/99-xdebug.ini
COPY ./docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

WORKDIR /var/www/tarkov
COPY . /var/www/tarkov

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.deb.sh' | bash
RUN apt install symfony-cli

RUN composer global config --no-plugins allow-plugins.symfony/flex true
RUN composer global config cache-dir '/tmp/composer-cache'

RUN groupadd -g 1000 tarkov && \
    useradd -u 1000 -g 1000 -d /var/www -s /bin/bash tarkov

USER tarkov