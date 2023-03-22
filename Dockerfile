FROM php:8.0-apache

ARG USER=www-data
ARG GROUP=www-data
ARG APACHE_DOCUMENT_ROOT=/var/www/html

RUN sed -i "s@deb.debian.org@mirrors.aliyun.com@g" /etc/apt/sources.list

RUN set -x ; \
    apt update && apt install -yqq libzip-dev libxml2-dev ; \
    apt autoclean && apt autoremove ; \
    docker-php-ext-install pdo pdo_mysql zip xml xmlwriter

ADD --chown=${USER}:${GROUP} . ${APACHE_DOCUMENT_ROOT}/zentaopms

RUN set -x ; \
    mkdir zentaopms/tmp/ ; \
    chmod -R 777 ${APACHE_DOCUMENT_ROOT}/zentaopms/www/data ; \
    chmod -R 777 ${APACHE_DOCUMENT_ROOT}/zentaopms/tmp ;

CMD apache2-foreground
