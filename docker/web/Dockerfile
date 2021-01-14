FROM ubuntu:18.04

LABEL author="icade"
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update -qq && apt-get install locales

RUN export LC_ALL=fr_FR.UTF-8
RUN export LANG=fr_FR.UTF-8
RUN locale-gen fr_FR.UTF-8

RUN apt-get update -qq
RUN apt-get install apache2 -y -qq && a2enmod ssl && a2enmod http2

RUN apt-get install vim -y -qq && apt-get install nano -y -qq

RUN rm /etc/apache2/sites-available/000-default.conf \
    && rm /etc/apache2/sites-enabled/000-default.conf

COPY ./docker/web/default.conf /etc/apache2/sites-enabled/

RUN apt-get update -qq && apt-get install software-properties-common -qq \
    && add-apt-repository ppa:ondrej/php

RUN apt-get install -qq php7.3

RUN apt-get install -qq php7.3-xml \
    && apt-get install -qq php7.3-pgsql \
    && apt-get install -qq php7.3-curl

RUN apt-get install zip unzip php7.3-zip -qq

# COPY ./docker/web/php.ini /etc/php/7.3/apache2/php.ini

EXPOSE 80

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN mv composer.phar /usr/local/bin/composer
RUN php -r "unlink('composer-setup.php');"

WORKDIR /var/www/Back/

COPY ./Back/composer* ./

RUN composer install --no-interaction

CMD /usr/sbin/apache2ctl -D FOREGROUND

RUN php bin/console c:c --env dev
