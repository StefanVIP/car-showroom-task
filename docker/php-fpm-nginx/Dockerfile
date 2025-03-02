FROM serversideup/php:7.4-fpm-nginx AS php-fpm-nginx

ENV PHP_OPCACHE_ENABLE=1
ENV PHP_DATE_TIMEZONE=Europe/Moscow
ENV PHP_MEMORY_LIMIT=512M

USER root

RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libpq-dev \
    && docker-php-ext-install pdo_mysql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

COPY .. .
RUN chown -R www-data:www-data /var/www/html

USER www-data

RUN composer install

FROM php-fpm-nginx AS php-fpm-nginx-dev

ENV PHP_OPCACHE_ENABLE=0
ENV SHOW_WELCOME_MESSAGE=false

USER root

RUN install-php-extensions xdebug

USER www-data

RUN composer global config --no-plugins allow-plugins.ergebnis/composer-normalize true  \
    && composer global require ergebnis/composer-normalize \
