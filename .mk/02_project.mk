##
## PROJECT
## -------
##

.PHONY: start
start: docker.start composer.install.check _ready ## Project: Start all (& install only if there have been changes).

.PHONY: stop
stop: docker.stop ## Project: Stop all.

.PHONY: tests
tests: phpunit ## Project: Launch all tests.

.PHONY: cc
cc: symfony.cc ## Project: Clear all cache.

.PHONY: chown.fix
chown.fix: ## Project: Editing permissions on Linux if you cannot edit some of the project files (set yourself as owner).
	$(DC) run --rm $(APP_NAME) chown -R $$(id -u):$$(id -g) .

#
#	"PRIVATE"
#

.PHONY: _build
_build: # Create 'build' folder.
	mkdir -p $(FOLDER_BUILD)

.PHONY: _build.clean
_build.clean: # Remove 'build' folder.
	rm -rf $(FOLDER_BUILD)

.PHONY: _ready
_ready:
	@echo -e "\033[1;42m"
	@echo -e "READY!"
	@echo -e "Open \e[4m$(LOCALHOST)\033[0m"
	@echo