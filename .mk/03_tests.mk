##
## TESTS
## -----
##

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

.PHONY: enable-xdebug
enable-xdebug: ## Xdebug : enable the module
	$(EXEC) --user 0 app sed -i.default "s/^;zend_extension=/zend_extension=/" $(XDEBUG_INI)
	@echo -e '\033[1;42mXdebug ON\033[0m';

.PHONY: disable-xdebug
disable-xdebug: ## Xdebug : disable the module
	$(EXEC) --user 0 app sed -i.default "s/^zend_extension=/;zend_extension=/" $(XDEBUG_INI)
	@echo -e '\033[1;41mXdebug OFF\033[0m';