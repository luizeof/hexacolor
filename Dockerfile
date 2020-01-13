FROM php:7.3-apache

LABEL "br.com.luizeof"="luizeof"
LABEL "name"="luizeof"
LABEL version="1.0.0"

ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update

RUN apt-get upgrade -y

RUN cd /tmp && curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

EXPOSE 80

COPY . /var/www/html/

CMD "apache2-foreground"
