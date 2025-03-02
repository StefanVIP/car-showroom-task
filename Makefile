.DEFAULT := help

help:
	@awk 'BEGIN {FS = ":.*##"; printf "\n\033[1mUsage:\n  make \033[36m<target>\033[0m\n"} \
	/^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-40s\033[0m %s\n", $$1, $$2 } /^##@/ \
	{ printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

COMPOSE_FILE_ARGS := -f docker/docker-compose.yaml

##@ Running

start: ## Start all containers
	docker compose $(COMPOSE_FILE_ARGS) up -d

stop: ## Stop all containers
	docker compose $(COMPOSE_FILE_ARGS) down --remove-orphans

rebuild: ## Rebuild all containers
	docker compose $(COMPOSE_FILE_ARGS) up -d --build

composer-install: ## Install composer dependencies inside php container
	docker compose $(COMPOSE_FILE_ARGS) run --rm --no-deps php composer install

bash: ## Enter in php container
	docker compose $(COMPOSE_FILE_ARGS) run --rm --no-deps php bash

##@ Database management

drop-and-create: ## Drop and create database
	docker compose $(COMPOSE_FILE_ARGS) run --rm --no-deps php bin/console doctrine:database:drop --force --if-exists
	docker compose $(COMPOSE_FILE_ARGS) run --rm --no-deps php bin/console doctrine:database:create --if-not-exists

test-drop-and-create: ## Drop and create test database
	docker compose $(COMPOSE_FILE_ARGS) run --rm --no-deps php bin/console doctrine:database:drop --force --if-exists --env=test
	docker compose $(COMPOSE_FILE_ARGS) run --rm --no-deps php bin/console doctrine:database:create --if-not-exists --env=test

migrate: ## Migrate database
	docker compose $(COMPOSE_FILE_ARGS) run --rm --no-deps php bin/console doctrine:migrations:migrate --no-interaction

test-migrate: ## Migrate test database
	docker compose $(COMPOSE_FILE_ARGS) run --rm --no-deps php bin/console doctrine:migrations:migrate --no-interaction --env=test

fixture: ## Load fixtures
	docker compose $(COMPOSE_FILE_ARGS) run --rm --no-deps php bin/console doctrine:fixtures:load --no-interaction --append

test-fixture: ## Load fixtures for test environment
	docker compose $(COMPOSE_FILE_ARGS) run --rm --no-deps php bin/console doctrine:fixtures:load --no-interaction --append --env=test

recreate-all: ## Drop and create database with migrations and fixtures
	docker compose $(COMPOSE_FILE_ARGS) run --rm --no-deps php bin/console doctrine:database:drop --force --if-exists
	docker compose $(COMPOSE_FILE_ARGS) run --rm --no-deps php bin/console doctrine:database:create --if-not-exists
	docker compose $(COMPOSE_FILE_ARGS) run --rm --no-deps php bin/console doctrine:migrations:migrate --no-interaction
	docker compose $(COMPOSE_FILE_ARGS) run --rm --no-deps php bin/console doctrine:fixtures:load --no-interaction --append

test-recreate-all: ## Drop and create database with migrations and fixtures for test environment
	docker compose $(COMPOSE_FILE_ARGS) run --rm --no-deps php bin/console doctrine:database:drop --force --if-exists --env=test
	docker compose $(COMPOSE_FILE_ARGS) run --rm --no-deps php bin/console doctrine:database:create --if-not-exists --env=test
	docker compose $(COMPOSE_FILE_ARGS) run --rm --no-deps php bin/console doctrine:migrations:migrate --no-interaction --env=test
	docker compose $(COMPOSE_FILE_ARGS) run --rm --no-deps php bin/console doctrine:fixtures:load --no-interaction --append --env=test

diff: ## Generate a new migration
	docker compose $(COMPOSE_FILE_ARGS) run --rm --no-deps php bin/console doctrine:migrations:diff

##@ Testing

test: ## Run tests
	docker compose $(COMPOSE_FILE_ARGS) run --rm --no-deps php composer test

phpstan: ## Run PHPStan
	docker compose $(COMPOSE_FILE_ARGS) run --rm --no-deps php composer phpstan
