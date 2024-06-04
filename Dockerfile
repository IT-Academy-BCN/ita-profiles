### SECCION DE NODE
# Fase de construcción de Node.js
FROM node:22 AS node

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos de React
COPY . /var/www/html

# Instalar dependencias de Node.js
RUN npm install

# Construir la aplicación React
RUN npm run build


### SECCION COMBINADA
# Fase final, combinando ambas
FROM php:8.1-fpm as php

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev libfreetype6-dev \
    libjpeg62-turbo-dev libpng-dev libonig-dev \
    libxml2-dev libpq-dev libicu-dev libxslt1-dev \
    libmcrypt-dev libssl-dev git zip unzip && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Copiar archivos de PHP desde la fase php
COPY . /var/www/html

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos de Node.js desde la fase node
COPY --from=node /var/www/html/build /var/www/html/build

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# write a line to force COPY .env.docker /var/www/html/.env
COPY .env.docker /var/www/html/.env

# Exponer el puerto 9000
EXPOSE 9000

CMD ["php-fpm"]
