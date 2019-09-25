SHELL=/bin/bash

DC = docker-compose
APP = $(DC) exec app
PHP = $(APP) php
#PHPUNIT = $(APP) ./bin/phpunit
PHPUNIT = $(APP) ./vendor/bin/simple-phpunit
ARTEFACTS = var/artefacts

.PHONY: start
start: ## Docker : builds, (re)creates, starts, and attaches to containers for a service.
	$(DC) up -d --remove-orphans

.PHONY: build
build: ##
	$(DC) up --build -d

.PHONY: stop
stop: ## Docker : stops running containers without removing them
	$(DC) stop

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
