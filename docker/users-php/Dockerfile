FROM php:7.4-fpm

RUN apt-get update && apt-get -y install \
    openssl\
    libonig-dev \
    git \
    unzip \
    zlib1g-dev \
    libicu-dev \
    libpq-dev \
    libfreetype6-dev \
    libmagickwand-dev \
    --no-install-recommends \
    && docker-php-ext-install opcache \
    && docker-php-ext-install intl \
    && docker-php-ext-install mbstring \
    && docker-php-ext-install pdo_pgsql

RUN apt-get install -y \
    iputils-ping \
    nano

RUN pecl install xdebug;
RUN docker-php-ext-enable xdebug
COPY ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN sed -i "s/xdebug.remote_autostart=0/xdebug.remote_autostart=1/" /usr/local/etc/php/conf.d/xdebug.ini && \
    sed -i "s/xdebug.remote_enable=0/xdebug.remote_enable=1/" /usr/local/etc/php/conf.d/xdebug.ini && \
    sed -i "s/xdebug.cli_color=0/xdebug.cli_color=1/" /usr/local/etc/php/conf.d/xdebug.ini

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./start.sh /tmp/start.sh
RUN chmod 775 /tmp/start.sh

#CMD  ["/var/www/start.sh"]
ENTRYPOINT ["/tmp/start.sh"]
CMD ["php-fpm"]

WORKDIR /var/www
