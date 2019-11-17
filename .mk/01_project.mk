## PROJECT

.PHONY: env.local.dev
env.local.dev: env.local.clean ## Project (Environment): Alias of `env.local.clean`.

.PHONY: env.local.prod
env.local.prod: .env.local.prod.dist ## Project (Environment): Copy `.env.local.prod.dist` into `.env.local` (APP_ENV=prod)
	cp .env.local.prod.dist .env.local
	$(MAKE) cc
	$(MAKE) symfony.about

.PHONY: env.local.test
env.local.test: .env.local.test.dist ## Project (Environment): Copy `.env.local.test.dist` into `.env.local` (APP_ENV=test)
	cp .env.local.test.dist .env.local
	$(MAKE) cc
	$(MAKE) symfony.about

.PHONY: env.local.clean
env.local.clean: ## Project (Environment): Remove `.env.local` and use default vars & environment of `.env` (APP_ENV=dev)
	rm -f .env.local
	$(MAKE) cc
	$(MAKE) symfony.about

##

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
install: install.local.dev ## Project: alias of 'install.local.dev'.

.PHONY: install.local.dev
install.local.dev: docker.start env.local.dev dependencies assets data fixtures ready ## Project: Install all (dependencies, data, assets, ...) (APP_ENV=dev).

.PHONY: install.local.prod
install.local.prod: docker.start env.local.prod dependencies assets.prod data ready ## Project: Install all (dependencies, data, assets, ...) (APP_ENV=prod).

##

.PHONY: dependencies
dependencies: composer.install yarn.install ## Project: Install the dependencies (only if there have been changes).

.PHONY: assets
assets: assets.dev ## Project: Alias of `assets.dev`

.PHONY: assets.dev
assets.dev: encore.compile ## Project: Generate all dev assets (webpack Encore, ...).

.PHONY: assets.prod
assets.prod: encore.deploy ## Project: Generate all production assets (webpack Encore, ...).

.PHONY: data
data: db.create ## Project: Install the data (db).

.PHONY: fixtures
fixtures: alice.fixtures.load ## Project: Load all fixtures.

##

.PHONY: check
check: install composer.validate symfony.security.check db.validate tests ## Project: Launch of install / Composer, Security and DB validations / Tests

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
# "PRIVATE"
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
	@echo -e "  APP_ENV:    $(APP_ENV) (value in Makefile)"
	@echo -e
	@echo -e "  Website:    \e[4m$(URL_WEBSITE)\\033[24m"
	@echo -e "  API:        \e[4m$(URL_API)\\033[24m"
	@echo -e "  phpMyAdmin: \e[4m$(URL_PHPMYADMIN)\\033[24m\033[0m"
	@echo
