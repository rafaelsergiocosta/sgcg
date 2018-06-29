FROM php:7.1-apache

#PHP
RUN apt-get update -y && apt-get install -y libpng-dev curl libcurl4-openssl-dev git wget build-essential gnupg zip unzip
RUN curl -sL https://deb.nodesource.com/setup_8.x | bash -
RUN apt-get install -y nodejs npm
RUN docker-php-ext-install pdo pdo_mysql gd curl zip
RUN npm install -g bower

#Xdebug
RUN pecl install xdebug && docker-php-ext-enable xdebug
RUN echo 'xdebug.remote_enable = 1' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo 'xdebug.remote_connect_back = 1' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo 'xdebug.remote_autostart = 1' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo 'xdebug.remote_host = 127.0.0.1' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo 'xdebug.remote_port = 9000' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

#Apache
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite
CMD apachectl -D FOREGROUND