FROM php:8.1-fpm
ARG XDEBUG_VERSION="xdebug-3.2.0"

RUN apt-get update
RUN apt-get install -y curl git procps vim nano

RUN yes | pecl install ${XDEBUG_VERSION} \
    && pecl install redis \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini \
&& docker-php-ext-enable xdebug \
&& docker-php-ext-enable redis

RUN docker-php-ext-install pdo pdo_mysql mysqli
ENV PHP_IDE_CONFIG 'serverName=cartproj.com'
RUN echo "xdebug.idekey = PHPSTORM" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.client_port=9001" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
COPY xdebug.ini "${PHP_INI_DIR}/conf.d"

WORKDIR /app