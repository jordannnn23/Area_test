FROM php:8.1-apache
RUN docker-php-ext-install pdo pdo_mysql sockets
RUN apt-get update -y && apt-get upgrade -y && apt-get install git libssl-dev -y
RUN pecl install mongodb && docker-php-ext-enable mongodb
# RUN echo "extension=mongodb.so" >> /usr/local/etc/php/php.ini
# RUN echo "extension=mongodb.so" > $PHP_INI_DIR/conf.d/mongodb.ini
RUN curl -sS https://getcomposer.org/installer​ | php -- \
     --install-dir=/usr/local/bin --filename=composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIR /app
COPY . .
RUN composer install
RUN php artisan key:generate
CMD ["php", "artisan", "serve", "--port=8080", "--host=0.0.0.0"]
EXPOSE 8080