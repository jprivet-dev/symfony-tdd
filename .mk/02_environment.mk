## ENVIRONMENT

.PHONY: env.app
env.app: ## Environment: Print current APP_ENV in Makefile.
	@echo -e '\033[1;43mAPP_ENV=$(APP_ENV)\033[0m';

.PHONY: env.local.dev
env.local.dev: env.local.clean ## Environment: Alias of `env.local.clean`.

.PHONY: env.local.prod
env.local.prod: .env.local.prod.dist ## Environment: [PROMPT yN] Copy '.env.local.prod.dist' into '.env.local' (APP_ENV=prod)
	@while [ -z "$$CONTINUE" ]; do \
		read -r -p "Create '.env.local' from '.env.local.prod.dist' ? [yN] " CONTINUE; \
	done ; \
	if [ $$CONTINUE == "y" ]; \
	then \
		cp .env.local.prod.dist .env.local; \
		$(MAKE_S) composer.dumpenv.prod; \
		$(MAKE_S) env.ready; \
		echo -e "\033[1;42m'.env.local' & '.env.local.php' created.\033[0m"; \
	else \
		$(MAKE_S) cancelled; \
	fi

.PHONY: env.local.test
env.local.test: .env.local.test.dist ## Environment: [PROMPT yN] Copy '.env.local.test.dist' into '.env.local' (APP_ENV=test)
	@while [ -z "$$CONTINUE" ]; do \
		read -r -p "Create '.env.local' from '.env.local.test.dist' ? [yN] " CONTINUE; \
	done ; \
	if [ $$CONTINUE == "y" ]; \
	then \
		cp .env.local.test.dist .env.local; \
		$(MAKE_S) env.ready; \
		echo -e "\033[1;42m'.env.local' created.\033[0m"; \
	else \
		$(MAKE_S) cancelled; \
	fi

.PHONY: env.local.clean
env.local.clean: ## Environment: [PROMPT yN] Remove '.env.local' and use default vars & environment of '.env' (APP_ENV=dev)
	@while [ -z "$$CONTINUE" ]; do \
		read -r -p "Remove '.env.local' and use '.env' by default ? [yN] " CONTINUE; \
	done ; \
	if [ $$CONTINUE == "y" ]; \
	then \
		rm -f .env.local; \
		rm -f .env.local.php; \
		rm -f .env.*.local; \
		$(MAKE_S) env.ready; \
		echo -e "\033[1;42m'.env.local', '.env.local.php' & '.env.*.local' removed.\033[0m"; \
	else \
		$(MAKE_S) cancelled; \
	fi

#
# INTERNAL
#

.PHONY: env.ready
env.ready:
	$(MAKE_S) cc
	$(MAKE_S) symfony.about
	$(MAKE_S) env.app
