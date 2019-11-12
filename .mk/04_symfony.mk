## SYMFONY

.PHONY: symfony.cc
symfony.cc: ## Symfony: Clear cache (current env).
	$(SYMFONY) cache:clear

.PHONY: symfony.ccp
symfony.ccp: ## Symfony: Clear cache (prod).
	$(SYMFONY) cache:clear --env=prod

.PHONY: symfony.cchard
symfony.cchard: ## Symfony: Remove all in `var/cache` folder.
	rm -rf var/cache/*

.PHONY: symfony.routes
symfony.routes: ## Symfony: Display current routes.
	$(SYMFONY) debug:router

##

.PHONY: symfony.security.check
symfony.security.check: ## Symfony: Check security of your dependencies. | https://github.com/sensiolabs/security-checker
	$(SYMFONY) security:check

.PHONY: symfony.fixtures.load
symfony.fixtures.load: ## Symfony / AliceBundle: load fixtures
	$(SYMFONY) hautelook:fixtures:load