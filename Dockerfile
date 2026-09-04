ARG PHP_VERSION=8.5
FROM php:${PHP_VERSION}-cli

RUN apt-get update && apt-get install -y git zip

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/bin/
RUN install-php-extensions redis pcntl

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
