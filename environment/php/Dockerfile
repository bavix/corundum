FROM php:7.2-fpm-alpine

# php install
RUN apk add gmp-dev \
   autoconf gcc g++ imagemagick imagemagick-dev libtool make \
   rabbitmq-c-dev \
   pngquant optipng gifsicle pngcrush \
   mysql-client

RUN apk add --no-cache libwebp freetype libpng libjpeg libjpeg-turbo \
   libwebp-dev freetype-dev libpng-dev libjpeg-dev libjpeg-turbo-dev && \
  docker-php-ext-configure gd \
    --with-gd \
    --with-freetype-dir=/usr/include/ \
    --with-png-dir=/usr/include/ \
    --with-webp-dir=/usr/include/ \
    --with-jpeg-dir=/usr/include/ && \
  NPROC=$(grep -c ^processor /proc/cpuinfo 2>/dev/null || 1) && \
  docker-php-ext-install -j${NPROC} gd

RUN pecl install imagick amqp
RUN docker-php-ext-enable imagick amqp
RUN docker-php-ext-install pdo_mysql zip bcmath gmp

# cleanup
RUN apk del --no-cache freetype-dev libpng-dev libjpeg-turbo-dev \
    libwebp-dev libjpeg-dev \
    gmp-dev imagemagick-dev rabbitmq-c-dev

# startup
WORKDIR /var/www/html

COPY ./docker-entrypoint /usr/local/bin/
RUN ln -s /usr/local/bin/docker-entrypoint / && chmod +x /docker-entrypoint

COPY ./startup.sh /usr/local/bin/startup
RUN ln -s /usr/local/bin/startup / && chmod +x /startup

COPY php.ini /usr/local/etc/php/

ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]
