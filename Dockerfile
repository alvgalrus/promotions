FROM php:8.4-cli-alpine
LABEL authors="Álvaro GR"

RUN wget https://getcomposer.org/installer -O - -q | php -- --install-dir=/usr/bin/ --filename=composer

WORKDIR /var/www/html/
