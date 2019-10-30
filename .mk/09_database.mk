## DATABASE

PHONY: db.create
db.create: _db.wait ## Database: Creates the configured database & Executes the SQL needed to generate the database schema.
	$(SYMFONY) doctrine:database:create --if-not-exists
	$(SYMFONY) doctrine:schema:create

PHONY: db.create.force
db.create.force: _db.wait db.drop db.create ## Database: Drop & create.

PHONY: db.drop
db.drop: ## Database: Drop.
	$(SYMFONY) doctrine:database:drop --if-exists --force

PHONY: db.validate
db.validate: ## Database: Validate the mapping files.
	$(SYMFONY) doctrine:schema:validate

##

PHONY: db.entities
db.entities: ## Database: List mapped entities.
	$(SYMFONY) doctrine:mapping:info

PHONY: db.bash
db.bash: ## Database: Bash access.
	$(EXEC_DB) bash

PHONY: db.mysql
db.mysql: ## Database: MySQL access (mysql> ...).
	$(EXEC_DB) bash -c "mysql -u $(DATABASE_USER) $(DATABASE_NAME)"

#
# "PRIVATE"
#

PHONY: _db.wait
# With new \Symfony\Component\Dotenv\Dotenv()
#@$(PHP) -r 'echo "Wait database... "; set_time_limit(15); require __DIR__."/vendor/autoload.php"; (new \Symfony\Component\Dotenv\Dotenv())->load(__DIR__."/.env"); $$host = getenv("DATABASE_HOST"); $$port = getenv("DATABASE_PORT"); echo "(".$$host.":".$$port.")\n"; for(;;) { if(@fsockopen($$host, $$port)) { break; }}'
_db.wait: # Database: Wait database...
	@$(PHP) -r 'echo "Wait database $(DATABASE_HOST):$(DATABASE_PORT)...\n"; set_time_limit(15); for(;;) { if(@fsockopen($(DATABASE_HOST), $(DATABASE_PORT))) { break; }};'
