## DOCKER

.PHONY: docker.start
# --remove-orphans: Remove containers for services not defined in the Compose file.
# -d: Detached mode: Run containers in the background, print new container names.
docker.start: ## Docker: Build, (re)create, start, and attache to containers for a service (detached mode). | https://docs.docker.com/compose/reference/up/
	docker-compose up --remove-orphans -d

.PHONY: docker.start.one
docker.start.one: docker.stop.all docker.start ## Docker: Stop all projects running containers & Start current project.

.PHONY: docker.build
# --build: Build images before starting containers.
# -d: Detached mode: Run containers in the background, print new container names.
docker.build: ## Docker: Same `docker.start` command + build images before starting containers (detached mode). | https://docs.docker.com/compose/reference/up/
	docker-compose up --build -d

.PHONY: docker.build.force
docker.build.force: docker.remove docker.build ## Docker: Stop, remove & rebuild current containers.

.PHONY: docker.stop
docker.stop: ## Docker: Stop running containers without removing them. | https://docs.docker.com/compose/reference/stop/
	docker-compose stop

.PHONY: docker.stop.all
docker.stop.all: ## Docker: Stop all projects running containers without removing them. | https://docs.docker.com/compose/reference/stop/
	docker stop $$(docker ps -a -q)

.PHONY: docker.down
# --remove-orphans: Remove containers for services not defined in the Compose file.
docker.down: ## Docker: [PROMPT yN] Stop containers and remove containers, networks, volumes, and images created by up. | https://docs.docker.com/compose/reference/down/
	@while [ -z "$$CONTINUE" ]; do \
		read -r -p "Stop containers and remove containers, networks, volumes, and images created by up? [yN] " CONTINUE; \
	done ; \
	if [ $$CONTINUE == "y" ]; \
	then \
		docker-compose down --remove-orphans; \
		echo -e "\033[1;42mContainers, networks, volumes, and images created by up removed\033[0m"; \
	else \
		$(MAKE_S) cancelled; \
	fi; \

##

.PHONY: docker.list
docker.list: ## Docker: List containers. | https://docs.docker.com/engine/reference/commandline/ps/
	docker ps

.PHONY: docker.list.stopped
# -a: Show all stopped containers (including those created by the run command)
# -q: Only display IDs
docker.list.stopped: ## Docker: List all stopped containers.
	docker ps -a

.PHONY: docker.remove
# --stop: Stop the containers, if required, before removing.
# -v: Remove any anonymous volumes attached to containers.
docker.remove: ## Docker: [PROMPT yN] Stop & Remove service containers (only current project). | https://docs.docker.com/compose/reference/rm/
	@while [ -z "$$CONTINUE" ]; do \
		read -r -p "Stop & Remove service containers (only current project)? [yN] " CONTINUE; \
	done ; \
	if [ $$CONTINUE == "y" ]; \
	then \
		docker-compose rm --stop -v; \
		echo -e "\033[1;42mStopped service containers removed\033[0m"; \
	else \
		$(MAKE_S) cancelled; \
	fi; \

.PHONY: docker.remove.all
docker.remove.all: ## Docker: [PROMPT yN] Remove all stopped service containers. | https://docs.docker.com/compose/reference/rm/
	@while [ -z "$$CONTINUE" ]; do \
		read -r -p "Remove all stopped service containers? [yN] " CONTINUE; \
	done ; \
	if [ $$CONTINUE == "y" ]; \
	then \
		docker rm -f $$(docker ps -a -q); \
		echo -e "\033[1;42mAll stopped service containers removed\033[0m"; \
	else \
		$(MAKE_S) cancelled; \
	fi; \

.PHONY: docker.images
docker.images: ## Docker: List images. | https://docs.docker.com/engine/reference/commandline/images/
	docker images

.PHONY: docker.images.remove.all
docker.images.remove.all: ## Docker: [PROMPT yN] Remove all unused images (for all projects!).
	@while [ -z "$$CONTINUE" ]; do \
		read -r -p "Remove all unused images (for all projects!)? [yN] " CONTINUE; \
	done ; \
	if [ $$CONTINUE == "y" ]; \
	then \
		docker rmi -f $$(docker images -q); \
		echo -e "\033[1;42mAll unused images removed\033[0m"; \
	else \
		$(MAKE_S) cancelled; \
	fi; \


.PHONY: docker.clean
docker.clean: ## Docker: [PROMPT yN] Remove unused data. | https://docs.docker.com/engine/reference/commandline/system_prune/
	@while [ -z "$$CONTINUE" ]; do \
		read -r -p "Remove unused data? [yN] " CONTINUE; \
	done ; \
	if [ $$CONTINUE == "y" ]; \
	then \
		docker system prune --volumes; \
		echo -e "\033[1;42mUnused data removed\033[0m"; \
	else \
		$(MAKE_S) cancelled; \
	fi; \

##

.PHONY: docker.env
docker.env: ## Docker: Show environment variables.
	$(EXEC_APP) env

.PHONY: docker.ip
docker.ip: ## Docker: Get ip Gateway.
	docker network inspect $(DOCKER_NETWORK_DEFAULT_NAME) | grep Gateway | grep -o -E '[0-9\.]+'

.PHONY: docker.ip.all
docker.ip.all: ## Docker: List all containers ip.
	docker inspect --format '{{ .Config.Hostname }} {{ .Name }} {{ .NetworkSettings.IPAddress }}' $$(docker ps -a -q)

.PHONY: docker.networks
docker.networks: ## Docker: list networks. | https://docs.docker.com/engine/reference/commandline/network/
	docker network ls

.PHONY: docker.logs
docker.logs: ## Docker: Show logs.
	docker-compose logs -f -t $(SERVICE_APP)

#.PHONY: docker.zsh
#docker.zsh: ## Docker: zsh access.
#	$(EXEC_APP_ROOT) zsh



