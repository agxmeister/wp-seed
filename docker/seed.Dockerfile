FROM php:8.3-fpm

SHELL ["/bin/bash", "-c"]

RUN apt-get update && apt-get install -y libzip-dev zip && docker-php-ext-install zip mysqli

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN composer global require codeception/codeception
ENV PATH="/root/.composer/vendor/bin:${PATH}"

WORKDIR "/var/seed"
