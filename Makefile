.DEFAULT_GOAL := help

SHELL := /bin/bash
COMPOSE := docker compose -f docker/docker-compose.yml
APP := $(COMPOSE) exec -T php

##@ Setup

.PHONY: start
start: up composer ## Boots the application in development mode

up:
	$(COMPOSE) up -d --build --force-recreate

.PHONY: stop
stop: ## Stop and clean-up the application (remove containers, networks, images, and volumes)
	$(COMPOSE) down -v --remove-orphans

.PHONY: composer
composer: ## Installs the latest Composer dependencies within running instance
	$(APP) composer install --no-interaction --no-ansi

db: ## (Re)creates the development database (with migrations)
	$(APP) bin/console doctrine:database:create
	$(APP) bin/console doctrine:schema:create

##@ Frontend

.PHONY: yarn
yarn: ## Run a yarn command with an argument (eg make yarn cmd='add react react-dom')
	$(COMPOSE) run node yarn $(cmd)

.PHONY: yarn-install
yarn-install: ## Installs yarn deps
	$(COMPOSE) run node yarn install

.PHONY: yarn-build
yarn-build: ## Build frontend assets
	$(COMPOSE) run node yarn build

.PHONY: yarn-watch
yarn-watch: ## Yarn dev mode
	$(COMPOSE) run node yarn build --watch

##@ Running Instance

.PHONY: shell
shell: ## Provides shell access to the running PHP container instance
	$(COMPOSE) exec php bash

.PHONY: logs
logs: ## Tails all container logs
	$(COMPOSE) logs -f

.PHONY: open-web
open-web: ## Opens the website in the default browser
	open "http://0.0.0.0:8080"

_require_%:
	@_=$(or $($*),$(error "`$*` env var required"))

# https://blog.thapaliya.com/posts/well-documented-makefiles/
.PHONY: help
help:
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n"} /^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)
