## DATABASE

PHONY: db.create
db.create: db.wait ## Database: Creates the configured database & Executes the SQL needed to generate the database schema.
	$(SYMFONY) doctrine:database:create --if-not-exists
	$(SYMFONY) doctrine:schema:create

PHONY: db.create.force
db.create.force: db.wait db.drop db.create ## Database: Drop & create.

PHONY: db.drop
db.drop: db.wait ## Database: Drop.
	$(SYMFONY) doctrine:database:drop --if-exists --force

PHONY: db.validate
db.validate: db.wait ## Database: Validate the mapping files.
	$(SYMFONY) doctrine:schema:validate

##

PHONY: db.entities
db.entities: db.wait ## Database: List mapped entities.
	$(SYMFONY) doctrine:mapping:info

PHONY: db.bash
db.bash: ## Database: Bash access.
	$(EXEC_DB) bash

PHONY: db.mysql
db.mysql: db.wait ## Database: MySQL access (mysql> ...).
	$(EXEC_DB) bash -c "mysql -u $(DATABASE_USER) $(DATABASE_NAME)"

#
# "PRIVATE"
#

PHONY: db.wait
# WARNING:
# Error at the very first execution of '$ docker-compose exec db bash -c "mysql -u root symfony_tdd_db"'
# ERROR 2002 (HY000): Can't connect to local MySQL server through socket '/var/run/mysqld/mysqld.sock' (2)
# The second time the command is executed, everything works !
# SOLUTION:
# This error occurs when the initialization of MySQL is not complete.
# See 'No connections until MySQL init completes' on https://hub.docker.com/_/mysql
# The 'db.wait' Makefile command has been created to wait until MySQL is available before any action is taken.
#
# With new \Symfony\Component\Dotenv\Dotenv()
#@$(PHP) -r 'echo "Wait database... "; set_time_limit(15); require __DIR__."/vendor/autoload.php"; (new \Symfony\Component\Dotenv\Dotenv())->load(__DIR__."/.env"); $$host = getenv("DATABASE_HOST"); $$port = getenv("DATABASE_PORT"); echo "(".$$host.":".$$port.")\n"; for(;;) { if(@fsockopen($$host, $$port)) { break; }}'
db.wait: # Database: Wait database...
	@$(PHP) -r 'echo "\e[0;43mWait database $(DATABASE_HOST):$(DATABASE_PORT)...\e[0m\n"; \
	set_time_limit(15); for(;;) { if(@fsockopen($(DATABASE_HOST), $(DATABASE_PORT))) { break; }}; echo "\e[0;42mDatabase ready!\e[0m\n";'