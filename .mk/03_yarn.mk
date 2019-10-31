## YARN

.PHONY: yarn.install
yarn.install: ## Yarn: Install all dependencies.
	@echo -e "\033[1;43mYarn: Install\033[0m"
	$(YARN) install

.PHONY: yarn.upgrade
yarn.upgrade: ## Yarn: Upgrade packages to their latest version based on the specified range.
	@echo -e "\033[1;43mYarn: Upgrade\033[0m"
	$(YARN) upgrade

.PHONY: yarn.encore.compile
yarn.encore.compile: ## Webpack Encore: Compile assets once.
	$(YARN) encore dev

.PHONY: yarn.encore.watch
yarn.encore.watch: ## Webpack Encore: Recompile assets automatically when files change.
	$(YARN) encore dev --watch --watch-poll=300

.PHONY: yarn.encore.deploy
yarn.encore.deploy: ## Webpack Encore: On deploy, create a production build.
	$(YARN) encore production