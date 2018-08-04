FROM php:7.2-alpine

# php install
RUN apk add libmcrypt-dev \
   autoconf gcc g++ imagemagick imagemagick-dev libtool make \
   libssh-dev rabbitmq-c-dev \
   libwebp libwebp-dev libpng-dev libjpeg pngquant \
   optipng gifsicle pngcrush \
   mysql-client \
   supervisor \
   && pecl install imagick amqp \
   && docker-php-ext-enable imagick amqp \
   && docker-php-ext-install pdo_mysql zip bcmath

CMD ["supervisord", "--nodaemon", "-c", "/etc/supervisord.conf"]
