## PHPUNIT

.PHONY: phpunit
phpunit: xdebug.off ## PHPUnit: Launch all tests (unit, functional, ...).
	$(PHPUNIT)

.PHONY: phpunit.coverage
phpunit.coverage: xdebug.on _build ## PHPUnit: Generate code coverage report in HTML format.
	$(PHPUNIT) --coverage-html $(PHPUNIT_COVERAGE)

.PHONY: phpunit.coverage.clover
phpunit.coverage.clover: xdebug.on _build ## PHPUnit: Generate code clover style coverage report.
	$(PHPUNIT) --coverage-clover $(PROJECT_BUILD)/logs/clover.xml

.PHONY: phpunit.coverage.open
phpunit.coverage.open: ## PHPUnit: Open code coverage report.
	gio open $(PHPUNIT_COVERAGE)/index.html

##

.PHONY: phpunit.unit
phpunit.unit: ## PHPUnit: Launch unit tests.
	$(PHPUNIT) --testsuite unit

.PHONY: phpunit.unit.coverage
phpunit.unit.coverage: xdebug.on _build ## PHPUnit: Generate code coverage report in HTML format for unit tests.
	$(PHPUNIT) --testsuite unit --coverage-html $(PHPUNIT_COVERAGE)

.PHONY: phpunit.functional
phpunit.functional: xdebug.off ## PHPUnit: Launch functional tests.
	$(PHPUNIT) --testsuite functional

.PHONY: phpunit.functional.coverage
phpunit.functional.coverage: xdebug.on _build ## PHPUnit: Generate code coverage report in HTML format for functional tests.
	$(PHPUNIT) --testsuite functional --coverage-html $(PHPUNIT_COVERAGE)

##

.PHONY: phpunit.watch
phpunit.watch: xdebug.off ## PHPUnit Watcher: Rerun automatically tests whenever you change some code. | https://github.com/spatie/phpunit-watcher
	$(PHPUNIT_WATCH)

.PHONY: phpunit.watch.unit
phpunit.watch.unit: xdebug.off ## PHPUnit Watcher: Rerun only unit tests.
	$(PHPUNIT_WATCH) --testsuite unit

.PHONY: phpunit.watch.functional
phpunit.watch.functional: xdebug.off ## PHPUnit Watcher: Rerun only functional tests.
	$(PHPUNIT_WATCH) --testsuite functional