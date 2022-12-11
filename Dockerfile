FROM php:8.0.5-fpm-alpine

RUN docker-php-ext-install pdo_mysql