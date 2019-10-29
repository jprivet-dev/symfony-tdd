## YARN

.PHONY: yarn.encore.compile
yarn.encore.compile: ## Yarn & Encore: Compile assets once.
	$(YARN) encore dev

.PHONY: yarn.encore.watch
yarn.encore.watch: ## Yarn & Encore: Recompile assets automatically when files change.
	$(YARN) encore dev --watch

.PHONY: yarn.encore.deploy
yarn.encore.deploy: ## Yarn & Encore: On deploy, create a production build.
	$(YARN) encore production