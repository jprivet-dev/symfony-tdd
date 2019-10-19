##
## DOCKER
## ------
##

# Variables

DOCKER_NETWORK_DEFAULT_NAME = symfony-tdd_default

# Commands

.PHONY: docker.start
# --remove-orphans: Remove containers for services not defined in the Compose file.
# -d: Detached mode: Run containers in the background, print new container names.
docker.start: ## Docker: Build, (re)create, start, and attache to containers for a service (detached mode). @see https://docs.docker.com/compose/reference/up/.
	$(DC) up --remove-orphans -d

.PHONY: docker.build
# --build: Build images before starting containers.
# -d: Detached mode: Run containers in the background, print new container names.
docker.build: ## Docker: Same `docker.start` command + build images before starting containers (detached mode). @see https://docs.docker.com/compose/reference/up/.
	$(DC) up --build -d

.PHONY: docker.stop
docker.stop: ## Docker: Stop running containers without removing them. @see https://docs.docker.com/compose/reference/stop/.
	$(DC) stop

.PHONY: docker.down
# --remove-orphans: Remove containers for services not defined in the Compose file.
docker.down: ## Docker: Stop containers and remove containers, networks, volumes, and images created by up. @see https://docs.docker.com/compose/reference/down/.
	$(DC) down --remove-orphans

##

.PHONY: docker.env
docker.env: ## Docker: Show environment variables.
	$(APP) env

.PHONY: docker.ip
docker.ip: ## Docker: Get ip Gateway.
	$(D) network inspect $(DOCKER_NETWORK_DEFAULT_NAME) | grep Gateway | grep -o -E '[0-9\.]+'

.PHONY: docker.containers
docker.containers: ## Docker: List containers.
	$(D) ps

.PHONY: docker.images
docker.images: ## Docker: List images.
	$(D) images

.PHONY: docker.networks
docker.networks: ## Docker: list networks.
	$(D) network ls

.PHONY: docker.logs
docker.logs: ## Docker: Show logs.
	$(DC) logs -f -t $(APP_NAME)

.PHONY: docker.sh
docker.sh: ## Docker: sh access.
	$(APP_ROOT) sh

#.PHONY: docker.zsh
#docker.zsh: ## Docker: zsh access.
#	$(APP_ROOT) zsh



