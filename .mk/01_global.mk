PROJECT_BUILD = build
PROJECT_SRC = src

URL_WEBSITE = http://localhost
URL_API = $(URL_WEBSITE)/api
URL_PHPMYADMIN = $(URL_WEBSITE):8088

XDEBUG_INI = /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

SERVICE_APP = app
SERVICE_DB = db
DOCKER_NETWORK_DEFAULT_NAME = symfony-tdd_default

EXEC = docker-compose exec
EXEC_APP = $(EXEC) $(SERVICE_APP)
EXEC_APP_ROOT = $(EXEC) --user 0 $(SERVICE_APP)
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
QA = docker run --rm -v `pwd`:/project mykiwi/phaudit:7.2

DATABASE_USER=root
DATABASE_PASSWORD=rootpass
DATABASE_HOST=db
DATABASE_PORT=3306
DATABASE_NAME=symfony_tdd
DATABASE_DRIVER=pdo_mysql