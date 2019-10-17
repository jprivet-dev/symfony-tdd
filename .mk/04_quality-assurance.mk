##
## QUALITY ASSURANCE
## -----------------
##

CODESNIFFER = $(PHP) ./vendor/bin/phpcs
CODESNIFFER_FIX = $(PHP) ./vendor/bin/phpcbf
MESSDETECTOR = $(PHP) ./vendor/bin/phpmd

.PHONY: codesniffer
codesniffer: ##
	$(CODESNIFFER) -n

.PHONY: codesniffer-fix
codesniffer-fix: ##
	$(CODESNIFFER_FIX)

.PHONY: messdetector
messdetector: ##
	$(MESSDETECTOR) ./src