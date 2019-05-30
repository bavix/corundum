FROM php:7.2-alpine

RUN apk add supervisor dcron

# php install
RUN apk add gmp-dev \
   autoconf gcc g++ imagemagick imagemagick-dev libtool make \
   rabbitmq-c-dev \
   pngquant optipng gifsicle pngcrush \
   mysql-client

RUN apk add --no-cache libwebp freetype libpng libjpeg libjpeg-turbo \
   libwebp-dev freetype-dev libpng-dev libjpeg-turbo-dev && \
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
RUN apk add jpegoptim optipng pngquant

# cleanup
RUN apk del --no-cache freetype-dev libpng-dev libjpeg-turbo-dev libwebp-dev \
    gmp-dev imagemagick-dev

COPY crontab /var/spool/cron/crontabs/root
COPY schedule /etc/periodic/minutely/
RUN chmod a+x /etc/periodic/minutely/*

COPY php.ini /usr/local/etc/php/

CMD ["supervisord", "--nodaemon", "-c", "/etc/supervisord.conf"]
