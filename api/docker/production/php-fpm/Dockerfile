FROM node:13-alpine AS node-builder

WORKDIR /srv/api

COPY ./package.json ./package-lock.json ./

RUN npm install && npm rebuild node-sass

COPY ./ ./

RUN npm run build

######################

FROM php:8.0-cli-alpine AS builder

RUN apk add --no-cache autoconf g++ make curl-dev pkgconfig openssl-dev \
    && pecl install redis opcache apcu \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis opcache apcu

RUN apk add --no-cache postgresql-dev fcgi icu-dev zip libzip-dev imap-dev libxml2-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-configure intl  \
    && docker-php-ext-configure zip  \
    && docker-php-ext-configure simplexml  \
    && docker-php-ext-install pdo_pgsql intl zip

RUN apk add --no-cache unzip

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet \
    && rm -rf /root/.composer/cache

WORKDIR /srv/api

COPY ./composer.json ./composer.lock ./

RUN composer install --prefer-dist --no-progress --no-suggest --optimize-autoloader \
    && rm -rf /root/.composer/cache

### FPM ###

FROM php:8.0-fpm-alpine

RUN apk add --no-cache autoconf g++ make curl-dev pkgconfig openssl-dev \
    && pecl install redis opcache apcu \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis opcache apcu

RUN apk add --no-cache postgresql-dev fcgi icu-dev zip libzip-dev imap-dev libxml2-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-configure intl  \
    && docker-php-ext-configure zip  \
    && docker-php-ext-configure simplexml  \
    && docker-php-ext-install pdo_pgsql intl zip

RUN mv $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini

COPY ./docker/common/php/conf.d /usr/local/etc/php/conf.d
COPY ./docker/common/php/php-fpm.d /usr/local/etc/php-fpm.d
COPY ./docker/production/php-fpm/conf.d /usr/local/etc/php/conf.d

WORKDIR /srv/api

COPY ./docker/production/php-fpm/entrypoint.sh /usr/local/bin/docker-php-entrypoint
RUN chmod +x /usr/local/bin/docker-php-entrypoint

COPY --from=builder /srv/api ./
COPY ./ ./

HEALTHCHECK --interval=5s --timeout=3s --start-period=1s \
    CMD REDIRECT_STATUS=true SCRIPT_NAME=/ping SCRIPT_FILENAME=/ping REQUEST_METHOD=GET \
    cgi-fcgi -bind -connect 127.0.0.1:9000 || exit 1