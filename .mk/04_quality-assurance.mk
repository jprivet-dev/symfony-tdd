##
## QUALITY ASSURANCE
## -----------------
##

# Variables

CODESNIFFER = $(PHP) ./vendor/bin/phpcs
CODESNIFFER_FIX = $(PHP) ./vendor/bin/phpcbf
MESSDETECTOR = $(PHP) ./vendor/bin/phpmd
QA = $(D) run --rm -v `pwd`:/project mykiwi/phaudit:7.2

# Commands

.PHONY: qa.phpmetrics
qa.phpmetrics: _build ## PHPMetrics: provides tons of metric (Complexity / Volume / Object Oriented / Maintainability). See http://www.phpmetrics.org
	$(QA) phpmetrics --report-html=$(FOLDER_BUILD)/phpmetrics $(FOLDER_SRC)

.PHONY: qa.codesniffer
qa.codesniffer: ##
	$(CODESNIFFER) -n

.PHONY: qa.codesniffer.fix
qa.codesniffer.fix: ##
	$(CODESNIFFER_FIX)

.PHONY: qa.messdetector
qa.messdetector: ##
	$(MESSDETECTOR) $(FOLDER_SRC)

.PHONY: qa.security.check
qa.security.check: ## Symfony security: check security of your dependencies. See https://security.symfony.com/
	$(APP) ./vendor/bin/security-checker security:check
