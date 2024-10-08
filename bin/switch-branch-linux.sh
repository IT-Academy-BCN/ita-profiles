#!/bin/bash

docker compose down
docker volume prune -f
docker network prune -f
if [ -d "../node_modules" ]; then sudo rm -Rf ../node_modules; fi
if [ -d "../vendor" ]; then sudo rm -Rf ../vendor; fi
docker compose up -d

