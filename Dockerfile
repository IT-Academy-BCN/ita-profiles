FROM ubuntu:22.04

ENV DEBIAN_FRONTEND=noninteractive

# Actualización del sistema e instalación de herramientas básicas
RUN apt-get update && apt-get install -y \
    curl \
    gnupg \
    software-properties-common \
    nginx \
    php8.1-fpm php8.1-mysql php8.1-cli php8.1-zip php8.1-curl php8.1-mbstring php8.1-bcmath php8.1-xml php8.1-intl php8.1-gd php8.1-soap \
    mariadb-server \
    redis-server \
    supervisor \
    git \
    unzip \
    netcat \
    && apt-get clean

# Instalación de Node.js 22.2
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean

# Crear carpetas necesarias para supervisor
RUN mkdir -p /var/log/supervisor /etc/supervisor/conf.d /run/mysqld /var/lib/redis /run/php \
    && chmod -R 777 /run/mysqld /var/lib/redis /run/php /var/www/html

# Copiar configuraciones y scripts
COPY supervisord.conf /etc/supervisor/supervisord.conf
COPY nginx/default.conf /etc/nginx/conf.d/default.conf
COPY entrypoint.sh /root/entrypoint.sh
COPY entrypoint_node.sh /root/entrypoint_node.sh
COPY init.sh /root/init.sh

# Permisos para los scripts
RUN chmod +x /root/entrypoint.sh /root/entrypoint_node.sh /root/init.sh

# Configuración del entorno de trabajo
WORKDIR /var/www/html
COPY . /var/www/html

RUN composer install

# Exponer puertos
EXPOSE 80 8000 3306 6379

# Comando de inicio
CMD ["/root/init.sh"]
