## PROJECT

.PHONY: start
start: docker.start install _ready ## Project: Start the project & Install only if there have been changes.

.PHONY: start.one
start.one: docker.stop.all start ## Project: Stop all containers & Execute `start` command.

.PHONY: stop
stop: docker.stop ## Project: Stop the project.

##

.PHONY: install
install: composer.install.changes yarn.install.changes ## Project: Install only if there have been changes.

.PHONY: tests
tests: phpunit ## Project: Launch all tests.

.PHONY: cc
cc: symfony.cc ## Project: Clear all cache.

.PHONY: chown.fix
chown.fix: ## Project: Editing permissions on Linux. See https://github.com/dunglas/symfony-docker#editing-permissions-on-linux.
	$(DOCKER_COMPOSE) run --rm $(SERVICE_APP) chown -R $$(id -u):$$(id -g) .

#
# "PRIVATE"
#

.PHONY: _build
_build: # Create 'build' folder.
	mkdir -p $(PROJECT_BUILD)

.PHONY: _build.clean
_build.clean: # Remove 'build' folder.
	rm -rf $(PROJECT_BUILD)

.PHONY: _ready
_ready:
	@echo -e "\033[1;42m"
	@echo -e "READY!"
	@echo -e "Website:    \e[4m$(URL_WEBSITE)\\033[24m"
	@echo -e "API:        \e[4m$(URL_API)\\033[24m"
	@echo -e "phpMyAdmin: \e[4m$(URL_PHPMYADMIN)\\033[24m\033[0m"
	@echo
