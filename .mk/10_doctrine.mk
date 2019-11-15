## DOCTRINE

PHONY: doctrine.database.create
doctrine.database.create: ## Doctrine: Create the configured database.
	$(SYMFONY) doctrine:database:create --if-not-exists

PHONY: doctrine.database.create.force
doctrine.database.create.force: doctrine.database.drop doctrine.database.create ## Doctrine: Drop & create the configured database.

PHONY: doctrine.database.drop
doctrine.database.drop: ## Doctrine: Drop the configured database.
	$(SYMFONY) doctrine:database:drop --if-exists --force

##

PHONY: doctrine.schema.validate
doctrine.schema.validate: ## Doctrine: Validate the mapping files.
	$(SYMFONY) doctrine:schema:validate

PHONY: doctrine.mapping.info
doctrine.mapping.info: ## Doctrine: List mapped entities.
	$(SYMFONY) doctrine:mapping:info