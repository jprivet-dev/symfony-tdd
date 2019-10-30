## XDEBUG

.PHONY: xdebug.on
xdebug.on: ## Xdebug: Enable the module.
	$(EXEC_APP_ROOT) sed -i.default "s/^;zend_extension=/zend_extension=/" $(XDEBUG_INI)
	@echo -e '\033[1;42mXdebug ON\033[0m';

.PHONY: xdebug.off
xdebug.off: ## Xdebug: Disable the module.
	$(EXEC_APP_ROOT) sed -i.default "s/^zend_extension=/;zend_extension=/" $(XDEBUG_INI)
	@echo -e '\033[1;43mXdebug OFF\033[0m';