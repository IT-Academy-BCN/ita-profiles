docker-compose down
docker system prune --all -f
docker volume prune -f
docker network prune -f
if [ $(docker network ls | grep app-network) ]; then sh ./disconnect_and_remove_network.sh; fi
docker network create app-network
if [ -d "../node_modules" ]; then sudo rm -Rf ../node_modules; fi
if [ -d "../vendor" ]; then sudo rm -Rf ../vendor; fi
docker compose up --build -d
docker network connect app-network mariadb
docker network connect app-network php
docker network connect app-network node
docker network connect app-network webserver
docker network connect app-network redis


