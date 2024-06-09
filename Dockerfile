FROM node:22.2.0 AS node-stage

WORKDIR /var/www/html

COPY package.json package-lock.json ./
RUN npm ci --cache /tmp/empty-cache
RUN npm install -g typescript

COPY . .

RUN npm run build

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

CMD ["php-fpm"]


FROM nginx:latest as nginx-stage
COPY ./nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf
COPY --from=php-stage /var/www/html /var/www/html
COPY --from=node-stage /var/www/html/build /var/www/html/build

EXPOSE 80
EXPOSE 8000
CMD ["nginx", "-g", "daemon off;"]
