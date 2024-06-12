#!/bin/sh

npm install
npm run build

# Ejecuta el comando recibido como argumento del entrypoint
exec "$@"
