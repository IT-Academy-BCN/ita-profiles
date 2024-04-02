# Utilizar la imagen oficial de PHP 8.1
FROM php:8.1.27

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-install pdo_mysql zip bcmath

# Instalar Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Establecer el directorio de trabajo
WORKDIR /var/www/html

# Exponer el puerto 8000
EXPOSE 80

# Iniciar el servidor web de PHP
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]
