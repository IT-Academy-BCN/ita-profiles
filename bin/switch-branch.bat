@echo off

docker compose down
docker volume prune -f
docker network prune -f

if exist "..\node_modules" (
    rmdir /s /q "..\node_modules"
)

if exist "..\vendor" (
    rmdir /s /q "..\vendor"
)

docker compose up -d
