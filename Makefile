.PHONY: up

up:
	docker compose up --build -d
down:
	docker compose down
full-restart:
	docker compose down && docker system prune --all -f && docker compose up --build -d
start:
	docker exec -it itaprofilesbackend-app php artisan serve --host=0.0.0.0 --port=8000
composer-install:
	docker exec -it itaprofilesbackend-app composer install
composer-update:
	docker exec -it itaprofilesbackend-app composer update
ssh:
	docker exec -it itaprofilesbackend-app bash
run-tests:
	docker exec -it itaprofilesbackend-app ./vendor/bin/phpunit -c phpunit.xml ./tests/ --testdox
swagger-generate:
	docker exec -it itaprofilesbackend-app php artisan l5-swagger:generate
