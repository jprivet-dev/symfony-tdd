##
## QUALITY ASSURANCE
## -----------------
##

# Variables

CODESNIFFER = $(PHP) ./vendor/bin/phpcs
CODESNIFFER_FIX = $(PHP) ./vendor/bin/phpcbf
MESSDETECTOR = $(PHP) ./vendor/bin/phpmd

# Commands

.PHONY: qa.codesniffer
qa.codesniffer: ##
	$(CODESNIFFER) -n

.PHONY: qa.codesniffer.fix
qa.codesniffer.fix: ##
	$(CODESNIFFER_FIX)

.PHONY: qa.messdetector
qa.messdetector: ##
	$(MESSDETECTOR) ./src

.PHONY: qa.security.check
qa.security.check: ## PHP Quality Assurance: check security of your dependencies (https://security.symfony.com/)
	$(APP) ./vendor/bin/security-checker security:check
