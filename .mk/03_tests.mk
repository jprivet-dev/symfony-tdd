##
## TESTS
## -----
##

# Variables

PHPUNIT = $(APP) ./vendor/bin/simple-phpunit
XDEBUG_INI = /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Commands

.PHONY: tests
tests: xdebug.off ## PHPUnit: launch all tests (unit, functional, ...)
	$(PHPUNIT)

.PHONY: tests.coverage
tests.coverage: xdebug.on ## PHPUnit: generate code coverage report in HTML format
	$(PHPUNIT) --coverage-html $(BUILD_FOLDER)/phpunit/coverage

.PHONY: tests.coverage.clover
tests.coverage.clover: xdebug.on ## PHPUnit: generate code clover style coverage report
	$(PHPUNIT) --coverage-clover build/logs/clover.xml

.PHONY: tests.unit
tests.unit: ## PHPUnit: launch unit tests
	$(PHPUNIT) --testsuite unit

.PHONY: tests.unit.coverage
tests.unit.coverage: xdebug.on ## PHPUnit: generate code coverage report in HTML format for unit tests
	$(PHPUNIT) --testsuite unit --coverage-html $(BUILD_FOLDER)/phpunit/coverage

.PHONY: tests.functional
tests.functional: xdebug.off ## PHPUnit: launch functional tests with dump
	$(PHPUNIT) --testsuite functional

.PHONY: tests.functional.coverage
tests.functional.coverage: xdebug.on ## PHPUnit: generate code coverage report in HTML format for functional tests
	$(PHPUNIT) --testsuite functional --coverage-html $(BUILD_FOLDER)/phpunit/coverage

##

.PHONY: xdebug.on
xdebug.on: ## Xdebug: enable the module
	$(APP_ROOT) sed -i.default "s/^;zend_extension=/zend_extension=/" $(XDEBUG_INI)
	@echo -e '\033[1;42mXdebug ON\033[0m';

.PHONY: xdebug.off
xdebug.off: ## Xdebug: disable the module
	$(APP_ROOT) sed -i.default "s/^zend_extension=/;zend_extension=/" $(XDEBUG_INI)
	@echo -e '\033[1;41mXdebug OFF\033[0m';