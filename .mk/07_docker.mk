##
## DOCKER
## ------
##

# Variables

DOCKER_NETWORK_DEFAULT_NAME = symfony-tdd_default

# Commands

.PHONY: docker.start
docker.start: ## Docker: builds, (re)creates, starts, and attaches to containers for a service (detached mode). See https://docs.docker.com/compose/reference/up/
	$(DC) up --remove-orphans -d

.PHONY: docker.build
docker.build: ## Docker: same `docker.start` command + build images before starting containers (detached mode). See https://docs.docker.com/compose/reference/up/
	$(DC) up --build -d

.PHONY: docker.stop
docker.stop: ## Docker: stops running containers without removing them. See https://docs.docker.com/compose/reference/stop/
	$(DC) stop

.PHONY: docker.down
docker.down: ## Docker: stops containers and removes containers, networks, volumes, and images created by up. See https://docs.docker.com/compose/reference/down/
	$(DC) down --remove-orphans

##

.PHONY: docker.env
docker.env: ## Docker: show environment variables
	$(APP) env

.PHONY: docker.ip
docker.ip: ## Docker: get ip Gateway
	$(D) network inspect $(DOCKER_NETWORK_DEFAULT_NAME) | grep Gateway | grep -o -E '[0-9\.]+'

.PHONY: docker.containers
docker.containers: ## Docker: list containers
	$(D) ps

.PHONY: docker.images
docker.images: ## Docker: list images
	$(D) images

.PHONY: docker.networks
docker.networks: ## Docker: list networks
	$(D) network ls

.PHONY: docker.logs
docker.logs: ## Docker: show logs
	$(DC) logs -f -t $(APP_NAME)

.PHONY: docker.sh
docker.sh: ## Docker: sh access
	$(APP_ROOT) sh

#.PHONY: docker.zsh
#docker.zsh: ## Docker: zsh access
#	$(APP_ROOT) zsh



