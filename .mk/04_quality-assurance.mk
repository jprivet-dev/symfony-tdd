##
## QUALITY ASSURANCE
## -----------------
##

.PHONY: codesniffer
codesniffer: ##
	$(CODESNIFFER) -n

.PHONY: codesniffer-fix
codesniffer-fix: ##
	$(CODESNIFFER_FIX)

.PHONY: messdetector
messdetector: ##
	$(MESSDETECTOR) ./src