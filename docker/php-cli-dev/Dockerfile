FROM php:8.3-cli-alpine

RUN apk update && apk upgrade && \
    apk add --no-cache icu-dev postgresql-dev libzip-dev g++ make && \
    docker-php-ext-configure intl && \
    docker-php-ext-install pdo_pgsql pgsql zip intl && \
    rm -rf /var/cache/apk/* && rm -rf /tmp/*

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

WORKDIR /app