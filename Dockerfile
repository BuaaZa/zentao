FROM php:8.0-apache

ARG USER=www-data
ARG GROUP=www-data
ARG APACHE_DOCUMENT_ROOT=/var/www/html

RUN docker-php-ext-install pdo pdo_mysql zip

ADD --chown=${USER}:${GROUP} . ${APACHE_DOCUMENT_ROOT}/zentaopms

RUN set -x ; \
    mkdir zentaopms/tmp/ ; \
    chmod -R 777 ${APACHE_DOCUMENT_ROOT}/zentaopms/www/data ; \
    chmod -R 777 ${APACHE_DOCUMENT_ROOT}/zentaopms/tmp ;

CMD apache2-foreground
