FROM php:8.1.27-apache
WORKDIR /var/www/html

RUN a2enmod rewrite

RUN apt-get update && apt-get install -y \
    libicu-dev \
    libmariadb-dev \
    unzip zip \
    zlib1g-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    git \
    libzip-dev \
    && pecl install xdebug \
    && docker-php-ext-install gettext intl pdo_mysql zip bcmath gd \
    && docker-php-ext-enable xdebug

RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


# Exponer el puerto 8000
#EXPOSE 80
#
## Iniciar el servidor web de PHP
CMD ["php", "artisan", "cache:clear"]
CMD ["php", "artisan", "config:clear"]
CMD ["php", "artisan", "config:cache"]
