docker compose down
docker system prune --all -f
docker volume prune -f
docker network prune -f
@REM if [ $$(docker network ls | grep app-network) ]; then sh ./bin/disconnect_and_remove_network.sh; fi
docker network create app-network
@REM if [ -d "./node_modules" ]; then sudo rm -Rf ./node_modules; fi
@REM if [ -d "./vendor" ]; then sudo rm -Rf ./vendor; fi
docker compose up --build -d
docker network connect app-network mysql
docker network connect app-network php
docker network connect app-network node
docker network connect app-network webserver
docker exec -it php bash -c 'if [ -f /var/www/html/bootstrap/cache/config.php ]; then rm /var/www/html/bootstrap/cache/config.php; fi'
docker exec -it php composer install
docker exec -it php composer clear-cache
docker exec -it php composer dump-autoload
docker exec -it php php artisan cache:clear
docker exec -it php php artisan config:clear
docker exec -it php php artisan optimize
docker exec -it php php artisan clear-compiled
docker exec -it php php artisan key:generate
docker exec -it php php artisan config:cache
docker exec -it php php artisan migrate:fresh --seed
docker exec -it php php artisan l5-swagger:generate
docker exec -it php cp .env.docker .env
docker exec -it php php artisan config:clear
docker exec -it php php artisan config:cache
docker exec -it php php artisan cache:clear
docker exec -it php php artisan key:generate
docker exec -it php php artisan passport:install --force --no-interaction
