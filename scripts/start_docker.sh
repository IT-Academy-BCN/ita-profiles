#!/bin/sh
BRANCH_NAME=$(git rev-parse --abbrev-ref HEAD)

docker build -t my-laravel-api:$BRANCH_NAME -f Dockerfile ./
docker run -d -p 80:8000 --name laravel_api_$BRANCH_NAME my-laravel-api:$BRANCH_NAME

# Esperar a que el contenedor esté listo
sleep 10
