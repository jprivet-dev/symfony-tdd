##
## DATABASE
## --------
##

# Variables

# env file data duplicated for the moment
DATABASE_USER=root
DATABASE_PASSWORD=rootpass
DATABASE_HOST=db
DATABASE_PORT=3306
DATABASE_NAME=symfony_tdd
DATABASE_DRIVER=pdo_mysql

# Commands

PHONY: db.bash
db.bash: ## Database: bash access
	$(DB) bash -c "mysql -u ${DATABASE_USER} -p${DATABASE_PASSWORD} ${DATABASE_NAME}"

PHONY: db.create
# With new \Symfony\Component\Dotenv\Dotenv()
#@$(PHP) -r 'echo "Wait database... "; set_time_limit(15); require __DIR__."/vendor/autoload.php"; (new \Symfony\Component\Dotenv\Dotenv())->load(__DIR__."/.env"); $$host = getenv("DATABASE_HOST"); $$port = getenv("DATABASE_PORT"); echo "(".$$host.":".$$port.")\n"; for(;;) { if(@fsockopen($$host, $$port)) { break; }}'
db.create: ## Database: drop & create
	@$(PHP) -r 'echo "Wait database... "; set_time_limit(15); $$host = "${DATABASE_HOST}"; $$port = "${DATABASE_PORT}"; echo "(".$$host.":".$$port.")\n"; for(;;) { if(@fsockopen($$host, $$port)) { break; }}'
	$(SYMFONY) doctrine:database:drop --if-exists --force
	$(SYMFONY) doctrine:database:create --if-not-exists
