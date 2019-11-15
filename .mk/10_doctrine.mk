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

##

PHONY: doctrine.migrations.diff
doctrine.migrations.diff: ## Doctrine: Generate a migration by comparing your current database to your mapping information.
	$(SYMFONY) doctrine:migrations:diff

PHONY: doctrine.migrations.migrate
doctrine.migrations.migrate: ## Doctrine: Execute a migration to the latest available version.
	$(SYMFONY) doctrine:migrations:migrate

PHONY: doctrine.migrations.migrate.nointeract
doctrine.migrations.migrate.nointeract: ## Doctrine: Execute a migration to the latest available version (no interaction).
	$(SYMFONY) doctrine:migrations:migrate --no-interaction
