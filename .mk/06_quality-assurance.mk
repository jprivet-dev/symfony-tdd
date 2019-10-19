##
## QUALITY ASSURANCE - STATIC ANALYZERS
## ------------------------------------
##

# Variables

CODESNIFFER = $(PHP) ./vendor/bin/phpcs
CODESNIFFER_FIX = $(PHP) ./vendor/bin/phpcbf
MESSDETECTOR = $(PHP) ./vendor/bin/phpmd
QA = $(D) run --rm -v `pwd`:/project mykiwi/phaudit:7.2

# Commands

.PHONY: qa.phpmetrics
qa.phpmetrics: _build ## PHPMetrics: Provide tons of metric (Complexity / Volume / Object Oriented / Maintainability). @see http://www.phpmetrics.org.
	$(QA) phpmetrics --report-html=$(FOLDER_BUILD)/phpmetrics $(FOLDER_SRC)

.PHONY: qa.codesniffer
qa.codesniffer: ## PHP_CodeSniffer: Tokenize PHP, JavaScript and CSS files and detect violations... @see https://github.com/squizlabs/PHP_CodeSniffer.
	$(CODESNIFFER) -n

.PHONY: qa.codesniffer.diff
qa.codesniffer.diff: ## PHP_CodeSniffer: Printing a diff report
	$(CODESNIFFER) --report=diff

.PHONY: qa.codesniffer.fix
qa.codesniffer.fix: ## PHP_CodeSniffer: Fixing errors automatically
	$(CODESNIFFER_FIX)

.PHONY: qa.messdetector
qa.messdetector: ## PHP Mess Detector: Scan PHP source code and look for potential problems... @see http://phpmd.org/.
	$(MESSDETECTOR) $(FOLDER_SRC) text codesize,unusedcode,naming,design

.PHONY: qa.security.check
qa.security.check: ## Symfony security: Check security of your dependencies. @see https://security.symfony.com/.
	$(APP) ./vendor/bin/security-checker security:check
