#!/bin/sh

npm install
npm run build
chmod -R 777 /var/www/html/node_modules

# Ejecuta el comando recibido como argumento del entrypoint
#exec "$@"
#Build continuously the react application (when changes are made):
npm run watch
