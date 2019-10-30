## COMPOSER

# This snippet will build the vendor directory, running composer install, only if the vendor directory does not exist.
# Or if composer.lock & composer.lock file has changed since the last time you built the vendor directory.
vendor: composer.json composer.lock
	@echo "\033[1;42mComposer : changes identified > triggered installation\033[0m"
	$(MAKE) composer.install

# This snippet will build the composer.lock file, running composer update, only if the composer.lock file does not exist.
# Or if composer.json file has changed since the last time you built the composer.lock file.
composer.lock: composer.json
	@echo "\033[1;42mComposer : changes identified > triggered update\033[0m"
	$(MAKE) composer.update

.PHONY: composer.install
composer.install: ## Composer: Read the composer.json/composer.lock file from the current directory, resolve the dependencies, and install them into vendor.
	$(COMPOSER) install --verbose

.PHONY: composer.install.changes
composer.install.changes: vendor ## Composer: Install (only if there have been changes).

.PHONY: composer.install.prod
composer.install.prod: ## Composer: Idem `composer.install` without dev elements.
	$(COMPOSER) install --verbose --no-progress --no-interaction --prefer-dist --optimize-autoloader --no-dev

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

