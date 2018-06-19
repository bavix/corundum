FROM php:7.1-fpm

# php install
RUN apt-get update && apt-get install -y libmcrypt-dev libssh-dev librabbitmq-dev \
   mysql-client libmagickwand-dev --no-install-recommends \
   && pecl install imagick amqp \
   && docker-php-ext-enable imagick amqp \
   && docker-php-ext-install mcrypt pdo_mysql zip

# startup
WORKDIR /var/www/html

COPY ./docker-entrypoint /usr/local/bin/
RUN ln -s /usr/local/bin/docker-entrypoint / && chmod +x /docker-entrypoint

COPY ./startup.sh /usr/local/bin/startup
RUN ln -s /usr/local/bin/startup / && chmod +x /startup

ENTRYPOINT ["docker-entrypoint"]
CMD ["php-fpm"]
