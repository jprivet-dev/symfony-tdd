## ENCORE

.PHONY: encore.compile
# Prevent "An exception has been thrown during the rendering of a template ("Asset manifest file "/srv/app/public/build/manifest.json" does not exist.")."
# See https://stackoverflow.com/questions/51393459/symfony-error-an-exception-has-been-thrown-during-the-rendering-of-a-template
encore.compile: ## Webpack Encore: Compile assets once.
	$(YARN) encore dev

.PHONY: encore.watch
encore.watch: ## Webpack Encore: Recompile assets automatically when files change.
	$(YARN) encore dev --watch

.PHONY: encore.deploy
encore.deploy: ## Webpack Encore: On deploy, create a production build.
	$(YARN) encore production