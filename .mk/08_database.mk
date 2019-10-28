## DATABASE

PHONY: db.wait
# With new \Symfony\Component\Dotenv\Dotenv()
#@$(PHP) -r 'echo "Wait database... "; set_time_limit(15); require __DIR__."/vendor/autoload.php"; (new \Symfony\Component\Dotenv\Dotenv())->load(__DIR__."/.env"); $$host = getenv("DATABASE_HOST"); $$port = getenv("DATABASE_PORT"); echo "(".$$host.":".$$port.")\n"; for(;;) { if(@fsockopen($$host, $$port)) { break; }}'
db.wait: ## Database: Wait database...
	@$(PHP) -r 'echo "Wait database $(DATABASE_HOST):$(DATABASE_PORT)...\n"; set_time_limit(15); for(;;) { if(@fsockopen($(DATABASE_HOST), $(DATABASE_PORT))) { break; }};'

PHONY: db.bash
db.bash: ## Database: Bash access (mysql> ...)
	$(EXEC_DB) bash -c "mysql -u $(DATABASE_USER) -p$(DATABASE_PASSWORD) $(DATABASE_NAME)"

PHONY: db.create
db.create: db.wait ## Database: Drop & create
	$(SYMFONY) doctrine:database:drop --if-exists --force
	$(SYMFONY) doctrine:database:create --if-not-exists
