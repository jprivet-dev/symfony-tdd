## YARN

.PHONY: yarn.install
yarn.install: ## Yarn: Install all dependencies.
	@echo -e "\033[1;43mYarn: Install\033[0m"
	$(YARN) install

.PHONY: yarn.upgrade
yarn.upgrade: ## Yarn: Upgrade packages to their latest version based on the specified range.
	@echo -e "\033[1;43mYarn: Upgrade\033[0m"
	$(YARN) upgrade

.PHONY: yarn.test
yarn.test: ## Yarn: Launch test package script (Jest).
	$(YARN) test