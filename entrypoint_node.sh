#!/bin/sh

npm install
npm run build
chmod -R 777 /var/www/html/node_modules

# Ejecuta el comando recibido como argumento del entrypoint
exec "$@"
