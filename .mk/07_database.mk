##
## DATABASE
## --------
##

# Variables

DATABASE_USER=user
DATABASE_PASSWORD=userpass
DATABASE_NAME=symfony_tdd

# Commands

PHONY: db.bash
db.bash: ## Database: bash access
	docker-compose exec db bash -c "mysql -u ${DATABASE_USER} -p${DATABASE_PASSWORD} ${DATABASE_NAME}"

PHONY: db.create
db.create: ## Database: drop & create
	@$(PHP) -r 'echo "Wait database... "; set_time_limit(15); require __DIR__."/vendor/autoload.php"; (new \Symfony\Component\Dotenv\Dotenv())->load(__DIR__."/.env"); $$host = getenv("DATABASE_HOST"); $$port = getenv("DATABASE_PORT"); echo "(".$$host.":".$$port.")\n"; for(;;) { if(@fsockopen($$host, $$port)) { break; }}'
	$(SYMFONY) doctrine:database:drop --if-exists --force
	$(SYMFONY) doctrine:database:create --if-not-exists
