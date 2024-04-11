.PHONY: up

up:
	docker compose up --build -d
down:
	docker compose down
full-restart:
	docker compose down && docker system prune --all -f && docker compose up --build -d
start:
	docker exec -it itaprofilesbackend-php php artisan serve --host=0.0.0.0 --port=8000
composer-install:
	docker exec -it itaprofilesbackend-php composer install
composer-update:
	docker exec -it itaprofilesbackend-php composer update
ssh:
	docker exec -it itaprofilesbackend-app bash
swagger-generate:
	docker exec -it itaprofilesbackend-php php artisan l5-swagger:generate
