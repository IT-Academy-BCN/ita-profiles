.PHONY: up down reboot serve composer-install composer-update setup render-setup cache-clear shell test test-method swagger-generate logs status kill-containers test-connectivity xdebug-on xdebug-off help switch-branch route-clear route-clear

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
	docker network connect app-network mariadb
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
	docker exec -it php cp .env.docker .env
	docker exec -it php php artisan cache:clear
	docker exec -it php php artisan config:clear
	docker exec -it php php artisan optimize
	docker exec -it php php artisan clear-compiled
	docker exec -it php php artisan key:generate
	docker exec -it php php artisan config:cache
	docker exec -it php chmod 777 -R storage
	docker exec -it php php artisan migrate:fresh --seed
	docker exec -it php php artisan l5-swagger:generate
	docker exec -it php php artisan passport:install --force --no-interaction

render-setup:
	bash -c 'if [ -f /var/www/html/bootstrap/cache/config.php ]; then rm /var/www/html/bootstrap/cache/config.php; fi'
	composer install
	composer clear-cache
	composer dump-autoload
	cp .env.docker .env
	php artisan cache:clear
	php artisan config:clear
	php artisan optimize
	php artisan clear-compiled
	php artisan key:generate
	php artisan config:cache
	php artisan migrate:fresh --seed
	php artisan l5-swagger:generate
	php artisan passport:install --force --no-interaction

cache-clear: ## Clear the cache
	docker exec -it php php artisan config:clear
	docker exec -it php php artisan config:cache
	docker exec -it php php artisan cache:clear

shell: ## Enters the specified container. Usage: make shell CONTAINER=<container_name>
	docker exec -it $(CONTAINER) bash

test: ## Run PHPUnit tests inside the container
	docker exec -it php ./vendor/bin/phpunit -c phpunit.xml ./tests/ --testdox

test-method: ## Run a PHPUnit test inside the container for a given method inside a test
	docker exec -it php ./vendor/bin/phpunit -c phpunit.xml $(FILE) --filter=$(METHOD) --testdox

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
	docker exec -it php bash -c "timeout 1 bash -c '</dev/tcp/mariadb/3306' && echo 'php to mariadb: OK' || echo 'php to mariadb: Failed'"
	docker exec -it php bash -c "timeout 1 bash -c '</dev/tcp/webserver/80' && echo 'php to webserver: OK' || echo 'php to webserver: Failed'"
	docker exec -it php bash -c "timeout 1 bash -c '</dev/tcp/node/80' && echo 'php to node: OK' || echo 'php to node: Failed'"
	docker exec -it webserver bash -c "timeout 1 bash -c '</dev/tcp/php/9000' && echo 'webserver to php: OK' || echo 'webserver to php: Failed'"
	docker exec -it webserver bash -c "timeout 1 bash -c '</dev/tcp/mariadb/3306' && echo 'webserver to mariadb: OK' || echo 'webserver to mariadb: Failed'"
	docker exec -it webserver bash -c "timeout 1 bash -c '</dev/tcp/node/80' && echo 'webserver to node: OK' || echo 'webserver to node: Failed'"
	docker exec -it mariadb bash -c "timeout 1 bash -c '</dev/tcp/php/9000' && echo 'mariadb to php: OK' || echo 'mariadb to php: Failed'"
	docker exec -it mariadb bash -c "timeout 1 bash -c '</dev/tcp/webserver/80' && echo 'mariadb to webserver: OK' || echo 'mariadb to webserver: Failed'"
	docker exec -it mariadb bash -c "timeout 1 bash -c '</dev/tcp/node/80' && echo 'mariadb to node: OK' || echo 'mariadb to node: Failed'"
	docker exec -it node bash -c "timeout 1 bash -c '</dev/tcp/php/9000' && echo 'node to php: OK' || echo 'node to php: Failed'"
	docker exec -it node bash -c "timeout 1 bash -c '</dev/tcp/webserver/80' && echo 'node to webserver: OK' || echo 'node to webserver: Failed'"
	docker exec -it node bash -c "timeout 1 bash -c '</dev/tcp/mariadb/3306' && echo 'node to mariadb: OK' || echo 'node to mariadb: Failed'"

xdebug-on: ## Enable xdebug
	docker exec -it php bash -c "echo 'zend_extension=xdebug' > /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
	echo 'xdebug.mode=debug,coverage' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
	echo 'xdebug.start_with_request=yes' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
	echo 'xdebug.client_host=host.docker.internal' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini"
	docker compose restart php
	docker exec -it php php artisan key:generate

xdebug-off: ## Disable xdebug
	docker exec -it php rm /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
	docker compose restart php
	docker exec -it php php artisan key:generate

help: ## Show this help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'

switch-branch: ## Switch the branch
	docker compose down
	docker volume prune -f
	docker network prune -f
	@if [ -f "./package-lock.json" ]; then \
    		if ! git diff --quiet HEAD -- ./package-lock.json; then \
    			echo "Changes detected in package-lock.json. Removing node_modules..."; \
    			sudo rm -rf ./node_modules; \
    		fi; \
    	fi
	@if [ -f "./composer.lock" ]; then \
    		if ! git diff --quiet HEAD -- ./composer.lock; then \
    			echo "Changes detected in composer.lock. Removing vendor..."; \
    			sudo rm -rf ./vendor; \
    		fi; \
    	fi
	docker compose up -d

route-clear: ## Clear the route cache
	docker exec -it php php artisan route:clear
	docker exec -it php php artisan route:cache
