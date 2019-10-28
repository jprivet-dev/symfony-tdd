.DEFAULT_GOAL := help

.PHONY: help
help:
	@grep -E '(^[a-zA-Z_-.]+[^:]+:.*##.*?$$)|(^#{2})' $(MAKEFILE_LIST) \
	| awk 'BEGIN {FS = "## "}; \
		{ \
			split($$1, command, ":"); \
			target=command[2]; \
			description=$$2; \
			# --- space --- \
			if (target=="##") \
				printf "\033[33m%s\n", ""; \
			# --- title --- \
			else if (target=="" && description!="") \
				printf "\033[33m\n%s\n", description; \
			# --- command + description --- \
			else if (target!="" && description!="")\
				printf "\033[32m %-30s \033[0m%s\n", target, description; \
			# --- print nothing --- \
			else \
				; \
		}'