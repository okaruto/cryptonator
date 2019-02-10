FROM php:7.1-fpm-alpine

WORKDIR /var/www/html

RUN apk update
RUN apk add --no-cache curl openssl $PHPIZE_DEPS \
 && pecl install xdebug \
 && docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

COPY ./phpunit.xml /var/www/html/phpunit.xml

COPY ./composer.json /var/www/html/composer.json
COPY ./composer.lock /var/www/html/composer.lock

RUN composer global require hirak/prestissimo \
 && composer install \
 && composer global remove hirak/prestissimo \
 && composer clear-cache

CMD composer test-coverage
