D = docker
DC = docker-compose
EXEC = $(DC) exec
APP_NAME = app
APP = $(EXEC) $(APP_NAME)
APP_ROOT = $(EXEC) --user 0 $(APP_NAME)
PHP = $(APP) php
BUILD_FOLDER = build