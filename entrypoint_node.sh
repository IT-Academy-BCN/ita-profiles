#!/bin/sh

npm install
npm run build
chmod -R 777 /var/www/html/node_modules

#Build continuously the react application (when changes are made):
# npm run watch
