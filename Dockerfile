# Basic setup to be used by other setups #
FROM alpine:3.7 AS base

WORKDIR /app

RUN adduser -D -g '' www-data

RUN apk --update add \
  git \
  php7-fpm \
  php7-json \
  php7-openssl \
  php7-mcrypt \
  php7-ctype \
  php7-zlib \
  php7-curl \
  php7-phar \
  php7-xml \
  php7-intl \
  php7-bcmath \
  php7-dom \
  php7-xmlreader \
  php7-mbstring \
  php7-iconv \
  php7-simplexml \
  php7-tokenizer \
  php7-session \
  php7-xmlwriter \
  curl \
  nodejs \
  nodejs-npm \
  && rm -rf /var/cache/apk/* \
  && npm install bower -g  \
  && npm install less -g  \
  && npm install yarn -g  \
  &&  curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
  && chown www-data:www-data /app

USER www-data

RUN composer global require "hirak/prestissimo:^0.3" --no-update \
    && composer global install --no-dev

USER root

EXPOSE 80

# Setup for local development only #
FROM base AS develop

RUN apk update \
    && echo "y" | apk add alpine-sdk mc vim git wget php7-dev autoconf \
    && wget https://xdebug.org/files/xdebug-2.6.0.tgz \
    && tar -xvzf xdebug-2.6.0.tgz \
    && cd xdebug-2.6.0 \
    && phpize \
    && ./configure \
    && make && make install \
    && cd .. \
    # && [ -d "xdebug-2.6.0" ] && rm -rf ./xdebug-2.6.0 \
    # && [ -f "xdebug-2.6.0.tgz" ] && rm xdebug-2.6.0.tgz \
    # && [ -f "package.xml" ] && rm package.xml \ \
    && php -i | grep xdebug \

    # ast php extension for phan
    && wget https://github.com/nikic/php-ast/archive/v1.0.0.tar.gz \
    && tar -xvzf v1.0.0.tar.gz \
    && cd php-ast-1.0.0 \
    && phpize \
    && ./configure \
    && make && make install \
    && cd ..

# Setup for CI #
FROM base AS testing

WORKDIR /app

RUN mkdir -p /var/run/php-fpm

ADD . /app

RUN composer install --no-interaction --no-progress \
    &&  bower update --allow-root \
    &&  yarn install \
    &&  ./node_modules/.bin/encore dev

RUN mkdir -p /app/var/cache /app/var/logs && chmod -R 777 /app/var/cache /app/var/logs










