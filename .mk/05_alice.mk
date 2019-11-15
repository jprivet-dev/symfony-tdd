## ALICE BUNDLE

.PHONY: alice.fixtures.load
alice.fixtures.load: ## AliceBundle: load fixtures.
	$(SYMFONY) hautelook:fixtures:load