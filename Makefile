SHELL=/bin/bash

DC = docker-compose
EXEC = $(DC) exec
APP = $(EXEC) app
PHP = $(APP) php
#PHPUNIT = $(PHP) bin/phpunit
PHPUNIT = $(APP) ./vendor/bin/simple-phpunit
CODESNIFFER = $(PHP) ./vendor/bin/phpcs
CODESNIFFER_FIX = $(PHP) ./vendor/bin/phpcbf
MESSDETECTOR = $(PHP) ./vendor/bin/phpmd
ARTEFACTS = var/artefacts
XDEBUG_INI = /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

.PHONY: start
start: ## Docker : builds, (re)creates, starts, and attaches to containers for a service.
	$(DC) up -d --remove-orphans

.PHONY: build
build: ##
	$(DC) up --build -d

.PHONY: stop
stop: ## Docker : stops running containers without removing them
	$(DC) stop

.PHONY: info
info: ## Docker : show ip Gateway, list of containers & images
	# ------------
	# Gateway host
	# ------------
	$(MAKE) ip
	# ---------------
	# List containers
	# ---------------
	docker ps
	# -----------
	# List images
	# -----------
	docker images

.PHONY: phpenv
phpenv: ## Docker (PHP container) : show environment variables
	$(APP) env

.PHONY: phplogs
phplogs: ## Docker (PHP container) : show logs
	$(DC) logs -f -t php

.PHONY: phpsh
phpsh: ## Docker (PHP container) : sh access
	$(DC) exec --user 0 app sh

.PHONY: tests
tests: ## PHPUnit: launch unit & fonctionnal tests
	$(PHPUNIT)

.PHONY: coverage
coverage: ## PHPUnit: generate code coverage report in HTML format
	$(PHPUNIT) --coverage-html $(ARTEFACTS)/phpunit/coverage

.PHONY: coverage-clover
coverage-clover: ## PHPUnit: generate code clover style coverage report
	$(PHPUNIT) --coverage-clover build/logs/clover.xml

.PHONY: unit-tests
unit-tests: ## PHPUnit: launch unit tests
	$(PHPUNIT) --testsuite unit

.PHONY: unit-tests-coverage
unit-tests-coverage: ## PHPUnit: generate code coverage report in HTML format for unit tests
	$(PHPUNIT) --testsuite unit --coverage-html $(ARTEFACTS)/phpunit/coverage

.PHONY: functional-tests
functional-tests: ## PHPUnit: launch functional tests with dump
	$(PHPUNIT) --testsuite functional

.PHONY: functional-tests-coverage
functional-tests-coverage: ## PHPUnit: generate code coverage report in HTML format for functional tests
	$(PHPUNIT) --testsuite functional --coverage-html $(ARTEFACTS)/phpunit/coverage

.PHONY: codesniffer
codesniffer:
	$(CODESNIFFER) -n

.PHONY: codesniffer-fix
codesniffer-fix:
	$(CODESNIFFER_FIX)

.PHONY: messdetector
messdetector:
	$(MESSDETECTOR) ./src

.PHONY: enable-xdebug
enable-xdebug: ## Xdebug : enable the module
	$(EXEC) --user 0 app sed -i.default "s/^;zend_extension=/zend_extension=/" $(XDEBUG_INI)
	@echo -e '\033[1;42mXdebug ON\033[0m';

.PHONY: disable-xdebug
disable-xdebug: ## Xdebug : disable the module
	$(EXEC) --user 0 app sed -i.default "s/^zend_extension=/;zend_extension=/" $(XDEBUG_INI)
	@echo -e '\033[1;41mXdebug OFF\033[0m';

