## DATABASE

# Variables

# .env file data duplicated for the moment
DATABASE_USER=root
DATABASE_PASSWORD=rootpass
DATABASE_HOST=db
DATABASE_PORT=3306
DATABASE_NAME=symfony_tdd
DATABASE_DRIVER=pdo_mysql

# Commands

PHONY: db.wait
# With new \Symfony\Component\Dotenv\Dotenv()
#@$(PHP) -r 'echo "Wait database... "; set_time_limit(15); require __DIR__."/vendor/autoload.php"; (new \Symfony\Component\Dotenv\Dotenv())->load(__DIR__."/.env"); $$host = getenv("DATABASE_HOST"); $$port = getenv("DATABASE_PORT"); echo "(".$$host.":".$$port.")\n"; for(;;) { if(@fsockopen($$host, $$port)) { break; }}'
db.wait: ## Database: Wait database...
	@$(PHP) -r 'echo "Wait database... "; set_time_limit(15); $$host = "${DATABASE_HOST}"; $$port = "${DATABASE_PORT}"; echo "(".$$host.":".$$port.")"; for(;;) { if(@fsockopen($$host, $$port)) { break; }}; echo "Database ready !")\n"'

PHONY: db.bash
db.bash: ## Database: Bash access (mysql> ...)
	$(DB) bash -c "mysql -u ${DATABASE_USER} -p${DATABASE_PASSWORD} ${DATABASE_NAME}"

PHONY: db.create
db.create: db.wait ## Database: Drop & create
	$(SYMFONY) doctrine:database:drop --if-exists --force
	$(SYMFONY) doctrine:database:create --if-not-exists
