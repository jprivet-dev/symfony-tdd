## DOCKER

.PHONY: docker.start
# --remove-orphans: Remove containers for services not defined in the Compose file.
# -d: Detached mode: Run containers in the background, print new container names.
docker.start: ## Docker: Build, (re)create, start, and attache to containers for a service (detached mode). | https://docs.docker.com/compose/reference/up/
	$(DOCKER_COMPOSE) up --remove-orphans -d

.PHONY: docker.start.one
docker.start.one: docker.stop.all docker.start ## Docker: Stop all projects running containers & Start current project.

.PHONY: docker.build
# --build: Build images before starting containers.
# -d: Detached mode: Run containers in the background, print new container names.
docker.build: ## Docker: Same `docker.start` command + build images before starting containers (detached mode). | https://docs.docker.com/compose/reference/up/
	$(DOCKER_COMPOSE) up --build -d

.PHONY: docker.build.force
docker.build.force: docker.stop docker.remove docker.build ## Docker: Stop, remove & rebuild current containers.

.PHONY: docker.stop
docker.stop: ## Docker: Stop running containers without removing them. | https://docs.docker.com/compose/reference/stop/
	$(DOCKER_COMPOSE) stop

.PHONY: docker.stop.all
docker.stop.all: ## Docker: Stop all projects running containers without removing them. | https://docs.docker.com/compose/reference/stop/
	$(DOCKER) stop $$($(DOCKER) ps -a -q)

.PHONY: docker.down
# --remove-orphans: Remove containers for services not defined in the Compose file.
docker.down: ## Docker: Stop containers and remove containers, networks, volumes, and images created by up. | https://docs.docker.com/compose/reference/down/
	$(DOCKER_COMPOSE) down --remove-orphans

.PHONY: docker.remove
# -v: Remove any anonymous volumes attached to containers.
docker.remove: ## Docker: Removes stopped service containers. | https://docs.docker.com/compose/reference/rm/
	$(DOCKER_COMPOSE) rm -v

.PHONY: docker.remove.all
docker.remove.all: ## Docker: Removes all stopped service containers. | https://docs.docker.com/compose/reference/rm/
	$(DOCKER) rm -f $$($(DOCKER) ps -a -q)

.PHONY: docker.list
docker.list: ## Docker: List containers. | https://docs.docker.com/engine/reference/commandline/ps/
	$(DOCKER) ps

.PHONY: docker.list.stopped
# -a: Show all stopped containers (including those created by the run command)
# -q: Only display IDs
docker.list.stopped: ## Docker: List all stopped containers.
	$(DOCKER) ps -a

##

.PHONY: docker.env
docker.env: ## Docker: Show environment variables.
	$(EXEC_APP) env

.PHONY: docker.ip
docker.ip: ## Docker: Get ip Gateway.
	$(DOCKER) network inspect $(DOCKER_NETWORK_DEFAULT_NAME) | grep Gateway | grep -o -E '[0-9\.]+'

.PHONY: docker.ip.all
docker.ip.all: ## Docker: List all containers ip.
	$(DOCKER) inspect --format '{{ .Config.Hostname }} {{ .Name }} {{ .NetworkSettings.IPAddress }}' $$($(DOCKER) ps -a -q)

.PHONY: docker.images
docker.images: ## Docker: List images. | https://docs.docker.com/engine/reference/commandline/images/
	$(DOCKER) images

.PHONY: docker.images.remove.all
docker.images.remove.all: ## Docker: Remove all unused images (for all projects!).
	@while [ -z "$$CONTINUE" ]; do \
		read -r -p "Remove all unused images (for all projects!)? [Y/n] " CONTINUE; \
	done ; \
	if [ $$CONTINUE == "Y" ]; \
	then \
		$(DOCKER) rmi -f $$($(DOCKER) images -q); \
		echo -e "\033[1;42mAll unused images removed\033[0m"; \
	else \
		echo -e "\033[1;43mAction cancelled\033[0m"; \
	fi; \

.PHONY: docker.networks
docker.networks: ## Docker: list networks. | https://docs.docker.com/engine/reference/commandline/network/
	$(DOCKER) network ls

.PHONY: docker.logs
docker.logs: ## Docker: Show logs.
	$(DOCKER_COMPOSE) logs -f -t $(SERVICE_APP)

.PHONY: docker.clean
docker.clean: ## Docker: Remove unused data. | https://docs.docker.com/engine/reference/commandline/system_prune/
	$(DOCKER) system prune --volumes

#.PHONY: docker.zsh
#docker.zsh: ## Docker: zsh access.
#	$(EXEC_APP_ROOT) zsh



