## YARN

# This snippet will build the node_modules directory, running yarn install, only if the node_modules directory does not exist.
# Or if yarn.lock & yarn.lock file has changed since the last time you built the node_modules directory.
node_modules: package.json yarn.lock
	@echo -e "\033[1;43mYarn: changes identified > triggered installation\033[0m"
	$(MAKE) yarn.install

# This snippet will build the yarn.lock file, running yarn upgrade, only if the yarn.lock file does not exist.
# Or if package.json file has changed since the last time you built the yarn.lock file.
yarn.lock: package.json
ifeq (,$(wildcard ./yarn.lock))
	@echo -e "\033[1;43mYarn: yarn.lock file does not exist > triggered install\033[0m"
	$(MAKE) yarn.install
else
	@echo -e "\033[1;43mYarn: changes identified > triggered upgrade\033[0m"
	$(MAKE) yarn.upgrade
endif

.PHONY: yarn.install
yarn.install: ## Yarn: Install all dependencies.
	$(YARN) install

.PHONY: yarn.install.changes
yarn.install.changes: node_modules ## Yarn: Install all dependencies (only if there have been changes).

.PHONY: yarn.upgrade
yarn.upgrade: ## Yarn: Upgrade packages to their latest version based on the specified range.
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