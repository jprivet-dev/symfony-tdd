## QUALITY ASSURANCE - STATIC ANALYZERS

.PHONY: qa.phpmetrics
qa.phpmetrics: _build ## PHPMetrics: Provide tons of metric (complexity / volume / object oriented / maintainability). | http://www.phpmetrics.org
	$(PHPMETRICS) --report-html=$(PROJECT_BUILD)/phpmetrics $(PROJECT_SRC)

.PHONY: qa.codesniffer
qa.codesniffer: ## PHP_CodeSniffer: Tokenize PHP, JavaScript and CSS files and detect violations... | https://github.com/squizlabs/PHP_CodeSniffer
	$(CODESNIFFER) -n

.PHONY: qa.codesniffer.diff
qa.codesniffer.diff: ## PHP_CodeSniffer: Printing a diff report
	$(CODESNIFFER) --report=diff

.PHONY: qa.codesniffer.fix
qa.codesniffer.fix: ## PHP_CodeSniffer: Fixing errors automatically
	$(CODESNIFFER_FIX)

.PHONY: qa.messdetector
qa.messdetector: ## PHP Mess Detector: Scan PHP source code and look for potential problems... | http://phpmd.org/
	$(MESSDETECTOR) $(PROJECT_SRC) text codesize,unusedcode,naming,design
