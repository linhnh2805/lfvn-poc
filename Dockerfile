FROM php:7.4-apache

#RUN apt-get update && apt-get install -y libzip-dev

#RUN docker-php-ext-install pdo_mysql mysqli

RUN apt-get update &&\
    apt-get install unzip vim cron -y

RUN docker-php-ext-install bcmath pdo_mysql

COPY www /var/www/html

RUN a2enmod rewrite headers

WORKDIR /var/www/html

RUN mkdir storage  bootstrap/cache storage/framework && cd storage/framework && mkdir sessions views cache cache/data
RUN chgrp -R www-data storage bootstrap/cache
RUN chmod -R ug+rwx storage bootstrap/cache
RUN php artisan cache:clear

# Install PHP Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# set the container entrypoint
CMD cron && apachectl -D FOREGROUND