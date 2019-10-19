##
## SYMFONY
## -------
##

.PHONY: symfony.cc
symfony.cc: ## Symfony : clear cache (current env)
	$(SYMFONY) cache:clear

.PHONY: symfony.ccp
symfony.ccp: ## Symfony : clear cache (prod)
	$(SYMFONY) cache:clear --env=prod

.PHONY: symfony.cchard
symfony.cchard: ## Symfony : removes all in `var/cache` folder
	rm -rf var/cache/*

.PHONY: symfony.routes
symfony.routes: ## Symfony : displays current routes
	$(SYMFONY) debug:router