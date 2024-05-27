.PHONY: up down full-restart start composer-install composer-update ssh run-tests swagger-generate logs kill-containers help

up: ## Bring up the Docker containers and build images if necessary
	docker compose up --build -d

down: ## Stop and remove the Docker containers
	docker compose down

full-restart: ## Perform a full restart: stop containers, remove all data, and bring up again
	docker compose down && docker system prune --all -f && docker compose up --build -d

start: ## Start the Laravel server in the container
	docker exec -it itaprofilesbackend-app php artisan serve --host=0.0.0.0 --port=8000

composer-install: ## Run 'composer install' inside the container
	docker exec -it itaprofilesbackend-app composer install

composer-update: ## Run 'composer update' inside the container
	docker exec -it itaprofilesbackend-app composer update

ssh: ## Open a bash session inside the container
	docker exec -it itaprofilesbackend-app bash

run-tests: ## Run PHPUnit tests inside the container
	docker exec -it itaprofilesbackend-app ./vendor/bin/phpunit -c phpunit.xml ./tests/ --testdox

swagger-generate: ## Generate Swagger documentation
	docker exec -it itaprofilesbackend-app php artisan l5-swagger:generate

logs: ## Show logs from all services in real time
	docker compose logs -f

kill-containers: ## Kill all running Docker containers
	@if [ "$$(docker ps -q)" ]; then \
		docker kill $$(docker ps -q); \
	else \
		echo "No containers are running."; \
	fi

help: ## Show this help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'
