@echo off
REM This is a Windows Batch Script equivalent of the Makefile

REM Bring up the Docker containers and build images if necessary
:up
docker compose up --build -d
goto :eof

REM Stop and remove the Docker containers
:down
docker compose down
goto :eof

REM Perform a full restart: stop containers, remove all data, and bring up again
:reboot
docker compose down
docker system prune --all -f
docker volume prune -f
docker network prune -f
if exist "./node_modules" (
    rmdir /s /q ".\node_modules"
)
if exist "./vendor" (
    rmdir /s /q ".\vendor"
)
docker compose up --build -d
docker network connect app-network mysql
docker network connect app-network php
docker network connect app-network node
docker network connect app-network webserver
goto :eof

REM Run 'composer install' inside the container
:composer-install
docker exec -it php composer install
goto :eof

REM Run 'composer update' inside the container
:composer-update
docker exec -it php composer update
goto :eof

REM Clear the cache
:cache-clear
docker exec -it php php artisan config:clear
docker exec -it php php artisan config:cache
docker exec -it php php artisan cache:clear
goto :eof

REM Enters the specified container. Usage: script.bat shell <container_name>
:shell
docker exec -it %2 bash
goto :eof

REM Run PHPUnit tests inside the container
:test
docker exec -it php ./vendor/bin/phpunit -c phpunit.xml ./tests/ --testdox
goto :eof

REM Generate Swagger documentation
:swagger-generate
docker exec -it php php artisan l5-swagger:generate
goto :eof

REM Show logs from all services in real time
:logs
docker compose logs -f
goto :eof

REM Shows the table of the containers with its status
:status
docker ps
goto :eof

REM Kill all running Docker containers
:kill-containers
docker kill $(docker ps -q)
goto :eof

REM Call the appropriate function
call :%1 %2
