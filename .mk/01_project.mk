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
install: env.app docker.start dependencies assets data ready ## Project: Install all (dependencies, data, assets, ...) according to the current environment (APP_ENV).

.PHONY: install.dev
install.dev: env.local.dev ## Project: Force the installation for the "dev" environment.
	$(MAKE_S) install

.PHONY: install.prod
install.prod: env.local.prod ## Project: Force the installation for the "prod" environment.
	$(MAKE_S) install

##

.PHONY: dependencies
dependencies: composer.install yarn.install ## Project: Install the dependencies (only if there have been changes).

.PHONY: assets
assets: ## Project: Generate all assets according to the current environment (APP_ENV).
	@echo -e "\033[1;43mGenerate assets (APP_ENV=$(APP_ENV))\033[0m"
ifeq ($(APP_ENV),prod)
	$(MAKE_S) assets.prod
else
	$(MAKE_S) assets.dev
endif

.PHONY: assets.dev
assets.dev: encore.compile ## Project: Generate all assets (webpack Encore, ...) for the "dev" environment.

.PHONY: assets.prod
assets.prod: encore.deploy ## Project: Generate all assets (webpack Encore, ...) for the "prod" environment.

.PHONY: data
data: db.create ## Project: Install the data (db).

.PHONY: fixtures
fixtures: alice.fixtures.load ## Project: Load all fixtures.

##

.PHONY: check
check: install.dev composer.validate symfony.security.check db.validate tests ## Project: Launch of install / Composer, Security and DB validations / Tests

.PHONY: tests
tests: fixtures phpunit ## Project: Launch all tests.

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
# INTERNAL
#

.PHONY: _build
_build: # Create 'build' folder.
	mkdir -p $(PROJECT_BUILD)

.PHONY: _build.clean
_build.clean: # Remove 'build' folder.
	rm -rf $(PROJECT_BUILD)

.PHONY: ready
ready: symfony.about.light
	@echo -e "\033[1;42m"
	@echo -e "READY!"
	@echo -e "  Website:    \e[4m$(URL_WEBSITE)\\033[24m"
	@echo -e "  API:        \e[4m$(URL_API)\\033[24m"
	@echo -e "  phpMyAdmin: \e[4m$(URL_PHPMYADMIN)\\033[24m\033[0m"
	@echo
	@$(MAKE_S) env.app