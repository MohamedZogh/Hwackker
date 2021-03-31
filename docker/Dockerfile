FROM php:7.4-fpm-alpine
WORKDIR "/application"

# Install selected extensions and other stuff
RUN apt-get update \
  && apt-get -y --no-install-recommends install sqlite3 php-sqlite3 php-xdebug libmcrypt-dev \
  && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer