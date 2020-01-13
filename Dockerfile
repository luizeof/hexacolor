FROM php:7.3-apache

MAINTAINER luizeof <luizeof@gmail.com>

# disable interactive functions
ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update

RUN apt-get upgrade -y

RUN cd /tmp && curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

EXPOSE 80

COPY . /var/www/html/
