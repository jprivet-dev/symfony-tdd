## YARN

.PHONY: yarn.install
yarn.install: package.json yarn.lock ## Yarn: Install.
	$(YARN) install

.PHONY: yarn.encore.compile
yarn.encore.compile: ## Webpack Encore: Compile assets once.
	$(YARN) encore dev

.PHONY: yarn.encore.watch
yarn.encore.watch: ## Webpack Encore: Recompile assets automatically when files change.
	$(YARN) encore dev --watch --watch-poll=300

.PHONY: yarn.encore.deploy
yarn.encore.deploy: ## Webpack Encore: On deploy, create a production build.
	$(YARN) encore production