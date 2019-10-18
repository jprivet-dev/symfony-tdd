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

.PHONY: symfony.routes
symfony.routes: ## Symfony : displays current routes
	$(SYMFONY) debug:router