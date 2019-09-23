SHELL=/bin/bash

DC = docker-compose

.PHONY: start
start: ## Docker : builds, (re)creates, starts, and attaches to containers for a service.
	$(DC) up -d --remove-orphans

.PHONY: build
build: ##
	$(DC) up --build -d

.PHONY: stop
stop: ## Docker : stops running containers without removing them
	$(DC) stop