FROM php:7.2-fpm-alpine

# php install
RUN apk add libmcrypt-dev \
   autoconf gcc g++ imagemagick imagemagick-dev libtool make \
   libssh-dev rabbitmq-c-dev \
   libwebp libwebp-dev libpng-dev libjpeg pngquant \
   optipng gifsicle pngcrush \
   mysql-client \
   && pecl install imagick amqp \
   && docker-php-ext-enable imagick amqp \
   && docker-php-ext-install pdo_mysql zip bcmath

# startup
WORKDIR /var/www/html

COPY ./docker-entrypoint /usr/local/bin/
RUN ln -s /usr/local/bin/docker-entrypoint / && chmod +x /docker-entrypoint

COPY ./startup.sh /usr/local/bin/startup
RUN ln -s /usr/local/bin/startup / && chmod +x /startup

COPY php.ini /usr/local/etc/php/

ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]
