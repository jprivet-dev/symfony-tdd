## PROJECT

.PHONY: start
start: docker.start ready ## Project: Start the current project.

.PHONY: start.one
start.one: docker.start.one ready ## Project: Stop all containers & start the current project.

.PHONY: stop
stop: docker.stop ## Project: Stop the current project.

.PHONY: sh
sh: ## Project: app sh access.
	$(EXEC_APP_ROOT) sh

##

.PHONY: install
install: docker.start dependencies assets data ready ## Project: Install all (dependencies, data, assets, ...).

.PHONY: dependencies
dependencies: composer.install yarn.install ## Project: Install the dependencies (only if there have been changes).

.PHONY: assets
assets: yarn.encore.compile ## Project: Generate all assets (webpack Encore, ...)

.PHONY: data
data: db.create.force ## Project: Install the data (db).

.PHONY: fixtures
fixtures: alice.fixtures.load ## Project: Load all fixtures.

##

.PHONY: check
check: install qa.codesniffer composer.validate symfony.security.check db.validate tests ## Project: Launch of install / PHP_CodeSniffer, Composer, Security and DB validations / Tests

.PHONY: tests
tests: phpunit ## Project: Launch all tests.

.PHONY: coverage
coverage: phpunit.coverage phpunit.coverage.open ## Project: Generate & open all code coverage reports.

##

.PHONY: cc
cc: symfony.cc ## Project: Clear all caches.

.PHONY: clean
clean: ## Project: [PROMPT Y/n] Remove build, vendor & node_modules folders.
	@while [ -z "$$CONTINUE" ]; do \
		read -r -p "Remove build, vendor & node_modules folders? [Y/n] " CONTINUE; \
	done ; \
	if [ $$CONTINUE == "Y" ]; \
	then \
		rm -rf build vendor node_modules; \
		echo -e "\033[1;42mbuild, vendor & node_modules removed\033[0m"; \
	else \
		echo -e "\033[1;43mAction cancelled\033[0m"; \
		exit 1; \
	fi; \

#
# "PRIVATE"
#

.PHONY: _build
_build: # Create 'build' folder.
	mkdir -p $(PROJECT_BUILD)

.PHONY: _build.clean
_build.clean: # Remove 'build' folder.
	rm -rf $(PROJECT_BUILD)

.PHONY: ready
ready:
	@echo -e "\033[1;42m"
	@echo -e "READY!"
	@echo -e "Website:    \e[4m$(URL_WEBSITE)\\033[24m"
	@echo -e "API:        \e[4m$(URL_API)\\033[24m"
	@echo -e "phpMyAdmin: \e[4m$(URL_PHPMYADMIN)\\033[24m\033[0m"
	@echo
