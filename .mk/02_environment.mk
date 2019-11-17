## ENVIRONMENT

.PHONY: env.app
env.app: ## Environment: Print current APP_ENV.
	@echo -e '\033[1;43mAPP_ENV=$(APP_ENV)\033[0m';

.PHONY: env.local.dev
env.local.dev: env.local.clean ## Environment: Alias of `env.local.clean`.

.PHONY: env.local.prod
env.local.prod: .env.local.prod.dist ## Environment: Copy `.env.local.prod.dist` into `.env.local` (APP_ENV=prod)
	cp .env.local.prod.dist .env.local
	$(MAKE_S) env.ready

.PHONY: env.local.test
env.local.test: .env.local.test.dist ## Environment: Copy `.env.local.test.dist` into `.env.local` (APP_ENV=test)
	cp .env.local.test.dist .env.local
	$(MAKE_S) env.ready

.PHONY: env.local.clean
env.local.clean: ## Environment: Remove `.env.local` and use default vars & environment of `.env` (APP_ENV=dev)
	rm -f .env.local
	$(MAKE_S) env.ready

#
# INTERNAL
#

.PHONY: env.ready
env.ready:
	$(MAKE_S) cc
	$(MAKE_S) symfony.about
	$(MAKE_S) env.app
