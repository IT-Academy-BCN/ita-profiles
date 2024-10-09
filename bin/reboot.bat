@echo off

docker compose down
docker system prune --all -f
docker volume prune -f
docker network prune -f

docker network ls | findstr app-network > nul
if %ERRORLEVEL% == 0 (
    call ./disconnect_and_remove_network.bat
)

docker network create app-network

if exist "..\node_modules" (
    rmdir /S /Q "..\node_modules"
)

if exist "..\vendor" (
    rmdir /S /Q "..\vendor"
)

docker compose up --build -d

docker network connect app-network mariadb
docker network connect app-network php
docker network connect app-network node
docker network connect app-network webserver
docker network connect app-network redis
