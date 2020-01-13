FROM php:7.3-apache

LABEL name="br.com.luizeof.hexacolor"
LABEL version="1.1.0"

ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update

RUN apt-get upgrade -y

RUN cd /tmp && curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

EXPOSE 80

RUN a2emod rewrite

COPY . /var/www/html/

RUN chown -R www-data:www-data /var/www/html

CMD ["apache2-foreground"]

