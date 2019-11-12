USER_ID = $(shell id -u)
GROUP_ID = $(shell id -g)

PROJECT_BUILD = build
PROJECT_SRC = src
PHPUNIT_COVERAGE = $(PROJECT_BUILD)/phpunit/coverage

URL_WEBSITE = http://localhost
URL_API = $(URL_WEBSITE)/api
URL_PHPMYADMIN = $(URL_WEBSITE):8088

XDEBUG_INI = /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

SERVICE_APP = app
SERVICE_DB = db
DOCKER_NETWORK_DEFAULT_NAME = symfony-tdd_default

EXEC = docker-compose exec
EXEC_USER = $(EXEC) --user $(USER_ID):$(GROUP_ID)
EXEC_ROOT = $(EXEC) --user 0

EXEC_APP = $(EXEC) $(SERVICE_APP)
EXEC_APP_ROOT = $(EXEC_ROOT) $(SERVICE_APP)
EXEC_DB = $(EXEC) $(SERVICE_DB)

COMPOSER = $(EXEC_APP) composer
PHP = $(EXEC_APP) php
PHPUNIT = $(EXEC_APP) ./vendor/bin/simple-phpunit
PHPUNIT_WATCH = $(EXEC_APP) ./vendor/bin/phpunit-watcher watch
YARN = $(EXEC_APP) yarn

SYMFONY = $(PHP) bin/console

CODESNIFFER = $(PHP) ./vendor/bin/phpcs
CODESNIFFER_FIX = $(PHP) ./vendor/bin/phpcbf
MESSDETECTOR = $(PHP) ./vendor/bin/phpmd
PHPMETRICS = docker run --rm -v `pwd`:/project mykiwi/phaudit:7.2 phpmetrics