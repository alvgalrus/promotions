FROM php:8.4-cli-alpine
LABEL authors="Álvaro GR"

#ARG UID
#ARG GID=${UID}

RUN apk update
RUN apk add curl
RUN curl -s https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

#USER ${UID}
WORKDIR /var/www/html/
#COPY composer.lock .
#RUN composer install
