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
    && docker-php-ext-install pdo_pgsql intl zip simplexml

RUN apk add --no-cache unzip

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet \
    && rm -rf /root/.composer/cache

WORKDIR /srv/api

COPY ./composer.json ./composer.lock ./

RUN composer install --prefer-dist --no-progress --no-suggest --optimize-autoloader \
    && rm -rf /root/.composer/cache

### CLI ###

FROM php:8.0-cli-alpine

RUN apk add --no-cache autoconf g++ make curl-dev pkgconfig openssl-dev \
    && pecl install redis opcache apcu \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis opcache apcu

RUN apk add --no-cache postgresql-dev fcgi icu-dev zip libzip-dev imap-dev libxml2-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-configure intl  \
    && docker-php-ext-configure zip  \
    && docker-php-ext-configure simplexml  \
    && docker-php-ext-install pdo_pgsql intl zip simplexml

RUN mv $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini

COPY ./docker/common/php/conf.d /usr/local/etc/php/conf.d
COPY ./docker/production/php-cli/conf.d /usr/local/etc/php/conf.d

COPY ./docker/common/wait-for-it.sh /usr/local/bin/wait-for-it
RUN chmod 555 /usr/local/bin/wait-for-it

WORKDIR /srv/api

COPY --from=builder /srv/api ./
COPY ./ ./
