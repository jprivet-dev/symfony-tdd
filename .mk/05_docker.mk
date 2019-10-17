##
## DOCKER
## ------
##

.PHONY: start
start: ## Docker : builds, (re)creates, starts, and attaches to containers for a service.
	$(DC) up -d --remove-orphans

.PHONY: build
build: ##
	$(DC) up --build -d

.PHONY: stop
stop: ## Docker : stops running containers without removing them
	$(DC) stop

.PHONY: info
info: ## Docker : show ip Gateway, list of containers & images
	# ------------
	# Gateway host
	# ------------
	$(MAKE) ip
	# ---------------
	# List containers
	# ---------------
	docker ps
	# -----------
	# List images
	# -----------
	docker images

.PHONY: phpenv
phpenv: ## Docker (PHP container) : show environment variables
	$(APP) env

.PHONY: phplogs
phplogs: ## Docker (PHP container) : show logs
	$(DC) logs -f -t php

.PHONY: phpsh
phpsh: ## Docker (PHP container) : sh access
	$(DC) exec --user 0 app sh

