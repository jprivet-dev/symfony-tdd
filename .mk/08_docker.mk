## DOCKER

# Variables

DOCKER_NETWORK_DEFAULT_NAME = symfony-tdd_default

# Commands

.PHONY: docker.start
# --remove-orphans: Remove containers for services not defined in the Compose file.
# -d: Detached mode: Run containers in the background, print new container names.
docker.start: ## Docker: Build, (re)create, start, and attache to containers for a service (detached mode). @see https://docs.docker.com/compose/reference/up/.
	$(DC) up --remove-orphans -d

.PHONY: docker.start.one
docker.start.one: docker.stop.all docker.start ## Docker: Stop all projects running containers & Start current project.

.PHONY: docker.build
# --build: Build images before starting containers.
# -d: Detached mode: Run containers in the background, print new container names.
docker.build: ## Docker: Same `docker.start` command + build images before starting containers (detached mode). @see https://docs.docker.com/compose/reference/up/.
	$(DC) up --build -d

.PHONY: docker.stop
docker.stop: ## Docker: Stop running containers without removing them. @see https://docs.docker.com/compose/reference/stop/.
	$(DC) stop

.PHONY: docker.stop.all
docker.stop.all: ## Docker: Stop all projects running containers without removing them. @see https://docs.docker.com/compose/reference/stop/.
	$(D) stop $$($(D) ps -a -q)

.PHONY: docker.down
# --remove-orphans: Remove containers for services not defined in the Compose file.
docker.down: ## Docker: Stop containers and remove containers, networks, volumes, and images created by up. @see https://docs.docker.com/compose/reference/down/.
	$(DC) down --remove-orphans

.PHONY: docker.remove
docker.remove: ## Docker: Removes stopped service containers. @see https://docs.docker.com/compose/reference/rm/.
	$(DC) rm

.PHONY: docker.remove.all
docker.remove.all: ## Docker: Removes all stopped service containers. @see https://docs.docker.com/compose/reference/rm/.
	$(D) rm -f $$($(D) ps -a -q)

.PHONY: docker.list
docker.list: ## Docker: List containers. @see https://docs.docker.com/engine/reference/commandline/ps/.
	$(D) ps

.PHONY: docker.list.stopped
# -a: Show all stopped containers (including those created by the run command)
# -q: Only display IDs
docker.list.stopped: ## Docker: List all stopped containers.
	$(D) ps -a

##

.PHONY: docker.env
docker.env: ## Docker: Show environment variables.
	$(APP) env

.PHONY: docker.ip
docker.ip: ## Docker: Get ip Gateway.
	$(D) network inspect $(DOCKER_NETWORK_DEFAULT_NAME) | grep Gateway | grep -o -E '[0-9\.]+'

.PHONY: docker.ip.all
docker.ip.all: ## Docker: List all containers ip.
	$(D) inspect --format '{{ .Config.Hostname }} {{ .Name }} {{ .NetworkSettings.IPAddress }}' $$($(D) ps -a -q)

.PHONY: docker.images
docker.images: ## Docker: List images. @see https://docs.docker.com/engine/reference/commandline/images/.
	$(D) images

.PHONY: docker.networks
docker.networks: ## Docker: list networks. @see https://docs.docker.com/engine/reference/commandline/network/.
	$(D) network ls

.PHONY: docker.logs
docker.logs: ## Docker: Show logs.
	$(DC) logs -f -t $(APP_SERVICE)

.PHONY: docker.sh
docker.sh: ## Docker: sh access.
	$(APP_ROOT) sh

#.PHONY: docker.zsh
#docker.zsh: ## Docker: zsh access.
#	$(APP_ROOT) zsh



