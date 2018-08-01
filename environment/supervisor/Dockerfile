FROM php:7.2

# php install
RUN apt-get update && apt-get install -y supervisor libmcrypt-dev libssh-dev librabbitmq-dev \
   mysql-client libmagickwand-dev --no-install-recommends \
   && pecl install imagick amqp \
   && docker-php-ext-enable imagick amqp \
   && docker-php-ext-install pdo_mysql zip bcmath \
   && rm -rf /var/lib/apt/lists/* \
   && sed -i 's/^\(\[supervisord\]\)$/\1\nnodaemon=true/' /etc/supervisor/supervisord.conf

CMD ["supervisord", "-c", "/etc/supervisor/supervisord.conf"]
