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

.PHONY: symfony.about
symfony.about: ## Symfony: Display information about the current project (Symfony, Kernel, PHP, Environment, ...).
	$(SYMFONY) about

.PHONY: symfony.env.vars
symfony.env.vars: ## Symfony: List defined environment variables. | https://symfony.com/doc/current/configuration.html#configuration-based-on-environment-variables
	$(SYMFONY) debug:container --env-vars

##

.PHONY: symfony.security.check
symfony.security.check: ## Symfony: Check security of your dependencies. | https://github.com/sensiolabs/security-checker
	$(SYMFONY) security:check