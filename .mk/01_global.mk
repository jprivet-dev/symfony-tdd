D = docker
DC = docker-compose
EXEC = $(DC) exec
APP_NAME = app
APP = $(EXEC) $(APP_NAME)
APP_ROOT = $(EXEC) --user 0 $(APP_NAME)
PHP = $(APP) php
COMPOSER = $(APP) composer
SYMFONY = $(PHP) bin/console

FOLDER_BUILD = build
FOLDER_SRC = src

LOCALHOST = http://localhost/