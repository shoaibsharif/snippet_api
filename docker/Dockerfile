FROM php:8-fpm-alpine

WORKDIR /srv

RUN apk --no-cache add shadow && usermod -u 1000 www-data

# PHP extension
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN install-php-extensions pdo_pgsql bcmath @composer redis
