##
## PHPUNIT
## -------
##

# Variables

PHPUNIT = $(APP) ./vendor/bin/simple-phpunit
PHPUNIT_WATCH = $(APP) ./vendor/bin/phpunit-watcher watch
XDEBUG_INI = /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Commands

.PHONY: phpunit
phpunit: ## PHPUnit: Launch all tests (unit, functional, ...).
	$(PHPUNIT)

.PHONY: phpunit.coverage
phpunit.coverage: xdebug.on _build ## PHPUnit: Generate code coverage report in HTML format.
	$(PHPUNIT) --coverage-html $(FOLDER_BUILD)/phpunit/coverage

.PHONY: phpunit.coverage.clover
phpunit.coverage.clover: xdebug.on _build ## PHPUnit: Generate code clover style coverage report.
	$(PHPUNIT) --coverage-clover $(FOLDER_BUILD)/logs/clover.xml

.PHONY: phpunit.unit
phpunit.unit: ## PHPUnit: Launch unit tests
	$(PHPUNIT) --testsuite unit

.PHONY: phpunit.unit.coverage
phpunit.unit.coverage: xdebug.on _build ## PHPUnit: Generate code coverage report in HTML format for unit tests.
	$(PHPUNIT) --testsuite unit --coverage-html $(FOLDER_BUILD)/phpunit/coverage

.PHONY: phpunit.functional
phpunit.functional: xdebug.off ## PHPUnit: Launch functional tests with dump
	$(PHPUNIT) --testsuite functional

.PHONY: phpunit.functional.coverage
phpunit.functional.coverage: xdebug.on _build ## PHPUnit: Generate code coverage report in HTML format for functional tests.
	$(PHPUNIT) --testsuite functional --coverage-html $(FOLDER_BUILD)/phpunit/coverage

##

.PHONY: phpunit.watch
phpunit.watch: xdebug.off ## PHPUnit Watcher: Rerun automatically tests whenever you change some code. @see https://github.com/spatie/phpunit-watcher.
	$(PHPUNIT_WATCH)

.PHONY: phpunit.watch.unit
phpunit.watch.unit: xdebug.off ## PHPUnit Watcher: Rerun only unit tests.
	$(PHPUNIT_WATCH) --testsuite unit

.PHONY: phpunit.watch.functional
phpunit.watch.functional: xdebug.off ## PHPUnit Watcher: Rerun only functional tests.
	$(PHPUNIT_WATCH) --testsuite functional

##

.PHONY: xdebug.on
xdebug.on: ## Xdebug: Enable the module.
	$(APP_ROOT) sed -i.default "s/^;zend_extension=/zend_extension=/" $(XDEBUG_INI)
	@echo -e '\033[1;42mXdebug ON\033[0m';

.PHONY: xdebug.off
xdebug.off: ## Xdebug: Disable the module.
	$(APP_ROOT) sed -i.default "s/^zend_extension=/;zend_extension=/" $(XDEBUG_INI)
	@echo -e '\033[1;41mXdebug OFF\033[0m';