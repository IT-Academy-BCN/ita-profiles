.PHONY: up down full-restart start composer-install composer-update ssh run-tests swagger-generate logs kill-containers help status

CONTAINER ?= php

up: ## Bring up the Docker containers and build images if necessary
	docker compose build --no-cache
	docker compose up -d

down: ## Stop and remove the Docker containers
	docker compose down

reboot: ## Perform a full restart: stop containers, remove all data, and bring up again
	docker compose down
	docker system prune --all -f
	docker volume prune -f
	docker network prune -f
	if [ $$(docker network ls | grep app-network) ]; then sh ./bin/disconnect_and_remove_network.sh; fi
	docker network create app-network
	if [ -d "./node_modules" ]; then sudo rm -Rf ./node_modules; fi
	if [ -d "./vendor" ]; then sudo rm -Rf ./vendor; fi
	docker compose --verbose build --no-cache
	docker compose up -d
	docker network connect app-network mysql
	docker network connect app-network php
	docker network connect app-network node
	docker network connect app-network webserver

serve: ## Start the Laravel server in the container
	docker exec -it php php artisan serve --host=0.0.0.0 --port=8000

composer-install: ## Run 'composer install' inside the container
	docker exec -it php composer install

composer-update: ## Run 'composer update' inside the container
	docker exec -it php composer update

setup: ## Does the setup of basic project's features like composer install, migrations, seeds, swagger, resets caches, key, passport...
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
	docker exec -it php chmod 777 -R storage

	docker exec -it php php artisan migrate:fresh --seed
	docker exec -it php php artisan l5-swagger:generate
	docker exec -it php cp .env.docker .env
	docker exec -it php php artisan config:clear
	docker exec -it php php artisan config:cache
	docker exec -it php php artisan cache:clear
	docker exec -it php php artisan key:generate
	docker exec -it php php artisan passport:install --force --no-interaction

render-setup:
	bash -c 'if [ -f /var/www/html/bootstrap/cache/config.php ]; then rm /var/www/html/bootstrap/cache/config.php; fi'
	composer install
	composer clear-cache
	composer dump-autoload
	php artisan cache:clear
	php artisan config:clear
	php artisan optimize
	php artisan clear-compiled
	php artisan key:generate
	php artisan config:cache
	php artisan migrate:fresh --seed
	php artisan l5-swagger:generate
	cp .env.docker .env
	php artisan config:clear
	php artisan config:cache
	php artisan cache:clear
	php artisan key:generate
	php artisan passport:install --force --no-interaction

cache-clear: ## Clear the cache
	docker exec -it php php artisan config:clear
	docker exec -it php php artisan config:cache
	docker exec -it php php artisan cache:clear

shell: ## Enters the specified container. Usage: make shell CONTAINER=<container_name>
	docker exec -it $(CONTAINER) bash

test: ## Run PHPUnit tests inside the container
	docker exec -it php ./vendor/bin/phpunit -c phpunit.xml ./tests/ --testdox

swagger-generate: ## Generate Swagger documentation
	docker exec -it php php artisan l5-swagger:generate

logs: ## Show logs from all services in real time
	docker compose logs -f

status: ## Shows the table of the containers withe its status
	docker ps

kill-containers: ## Kill all running Docker containers
	@if [ "$$(docker ps -q)" ]; then \
		docker kill $$(docker ps -q); \
	else \
		echo "No containers are running."; \
	fi

test-connectivity:
	docker exec -it php bash -c "timeout 1 bash -c '</dev/tcp/mysql/3306' && echo 'php to mysql: OK' || echo 'php to mysql: Failed'"
	docker exec -it php bash -c "timeout 1 bash -c '</dev/tcp/webserver/80' && echo 'php to webserver: OK' || echo 'php to webserver: Failed'"
	docker exec -it php bash -c "timeout 1 bash -c '</dev/tcp/node/80' && echo 'php to node: OK' || echo 'php to node: Failed'"
	docker exec -it webserver bash -c "timeout 1 bash -c '</dev/tcp/php/9000' && echo 'webserver to php: OK' || echo 'webserver to php: Failed'"
	docker exec -it webserver bash -c "timeout 1 bash -c '</dev/tcp/mysql/3306' && echo 'webserver to mysql: OK' || echo 'webserver to mysql: Failed'"
	docker exec -it webserver bash -c "timeout 1 bash -c '</dev/tcp/node/80' && echo 'webserver to node: OK' || echo 'webserver to node: Failed'"
	docker exec -it mysql bash -c "timeout 1 bash -c '</dev/tcp/php/9000' && echo 'mysql to php: OK' || echo 'mysql to php: Failed'"
	docker exec -it mysql bash -c "timeout 1 bash -c '</dev/tcp/webserver/80' && echo 'mysql to webserver: OK' || echo 'mysql to webserver: Failed'"
	docker exec -it mysql bash -c "timeout 1 bash -c '</dev/tcp/node/80' && echo 'mysql to node: OK' || echo 'mysql to node: Failed'"
	docker exec -it node bash -c "timeout 1 bash -c '</dev/tcp/php/9000' && echo 'node to php: OK' || echo 'node to php: Failed'"
	docker exec -it node bash -c "timeout 1 bash -c '</dev/tcp/webserver/80' && echo 'node to webserver: OK' || echo 'node to webserver: Failed'"
	docker exec -it node bash -c "timeout 1 bash -c '</dev/tcp/mysql/3306' && echo 'node to mysql: OK' || echo 'node to mysql: Failed'"

help: ## Show this help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'
