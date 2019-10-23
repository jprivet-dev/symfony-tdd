APP_SERVICE = app
DB_SERVICE = db

D = docker
DC = docker-compose
EXEC = $(DC) exec
APP = $(EXEC) $(APP_SERVICE)
APP_ROOT = $(EXEC) --user 0 $(APP_SERVICE)
PHP = $(APP) php
DB = $(EXEC) ${DB_SERVICE}

FOLDER_BUILD = build
FOLDER_SRC = src

LOCALHOST = http://localhost/