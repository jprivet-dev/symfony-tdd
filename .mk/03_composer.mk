##
## COMPOSER
## --------
##

# Variables

COMPOSER = $(APP) composer

# Commands

.PHONY: composer.install
composer.install: ## Composer: Read the composer.json/composer.lock file from the current directory, resolve the dependencies, and install them into vendor.
	$(COMPOSER) install --verbose

.PHONY: composer.update
# --lock: only update the lock file hash to suppress warning about the lock file being out of date
# --no-scripts: skip execution of scripts defined in composer.json
# --no-interaction: do not ask any interactive question
# --prefer-dist: install packages from dist when available
composer.update: ## Composer: Get the latest versions of the dependencies and update the composer.lock file.
	$(COMPOSER) update --lock --no-scripts --no-interaction --prefer-dist --verbose

.PHONY: composer.licenses
composer.licenses: ## Composer: List the name, version and license of every package installed.
	$(COMPOSER) licenses
