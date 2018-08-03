FROM php:7.2-fpm

# php install
RUN apt-get update && apt-get install -y libmcrypt-dev \
   imagemagick libssh-dev librabbitmq-dev \
   webp libwebp-dev libpng-dev libjpeg-progs pngquant \
   optipng gifsicle pngcrush \
   mysql-client libmagickwand-dev --no-install-recommends \
   && pecl install imagick amqp \
   && docker-php-ext-enable imagick amqp \
   && docker-php-ext-install pdo_mysql zip bcmath

# startup
WORKDIR /var/www/html

COPY ./docker-entrypoint /usr/local/bin/
RUN ln -s /usr/local/bin/docker-entrypoint / && chmod +x /docker-entrypoint

COPY ./startup.sh /usr/local/bin/startup
RUN ln -s /usr/local/bin/startup / && chmod +x /startup

ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]
