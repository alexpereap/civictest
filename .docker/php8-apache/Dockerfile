FROM php:8.1-apache
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY config/php-dev-xdebug.ini /usr/local/etc/php/conf.d/
COPY sites/civic.conf /etc/apache2/sites-available

RUN apt-get update
RUN apt-get install -y nano
RUN pecl install xdebug-3.1.2 \
    && docker-php-ext-enable xdebug
RUN apt-get install -y curl
# RUN curl -sL https://deb.nodesource.com/setup_14.x | bash
# RUN apt-get -y install nodejs
# RUN node --version
# RUN npm --version

RUN install-php-extensions xml \
    soap \
    pcntl \
    bcmath \
    zip \
    curl \
    redis


RUN a2enmod rewrite
RUN a2ensite civic

WORKDIR /var/www/civic-backend
CMD ["apache2-foreground"]
EXPOSE 80