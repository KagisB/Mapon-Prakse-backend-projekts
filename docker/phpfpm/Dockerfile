FROM php:8.1-fpm
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
