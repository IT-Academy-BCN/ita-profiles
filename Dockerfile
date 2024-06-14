FROM node:22.2.0 AS node-stage

WORKDIR /var/www/html

RUN mkdir -p /var/www/html/build
RUN npm install -g typescript


FROM php:8.1-fpm as php-stage

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    libzip-dev libfreetype6-dev \
    libjpeg62-turbo-dev libpng-dev libonig-dev \
    libxml2-dev libpq-dev libicu-dev libxslt1-dev \
    libmcrypt-dev libssl-dev git zip unzip && \
    apt-get clean && rm -rf /var/lib/apt/lists/*
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY .env.docker /var/www/html/.env

EXPOSE 9000

COPY ./entrypoint.sh /var/www/html/entrypoint.sh
RUN chmod +x /var/www/html/entrypoint.sh
ENTRYPOINT ["/var/www/html/entrypoint.sh"]

CMD ["php-fpm"]


FROM nginx:latest as nginx-stage
COPY ./nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf
COPY --from=php-stage /var/www/html /var/www/html
COPY --from=node-stage /var/www/html/build /var/www/html/build
RUN chmod -R 777 /var/www/html/build

EXPOSE 80
EXPOSE 8000

CMD ["nginx", "-g", "daemon off;"]
