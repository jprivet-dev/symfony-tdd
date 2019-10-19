##
## COMPOSER
## --------
##

.PHONY: composer.install
composer.install: ## Composer: reads the composer.json/composer.lock file from the current directory, resolves the dependencies, and installs them into vendor
	$(COMPOSER) install --verbose

.PHONY: composer.update
composer.update: ## Composer: gets the latest versions of the dependencies and updates the composer.lock file
	$(COMPOSER) update --lock --no-scripts --no-interaction --prefer-dist --verbose
# --lock: only updates the lock file hash to suppress warning about the lock file being out of date
# --no-scripts: skips execution of scripts defined in composer.json
# --no-interaction: do not ask any interactive question
# --prefer-dist: install packages from dist when available

.PHONY: composer.licenses
composer.licenses: ## Composer: lists the name, version and license of every package installed
	$(COMPOSER) licenses
