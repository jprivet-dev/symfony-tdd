.DEFAULT_GOAL := help

.PHONY: help
help:
	@grep -E '(^[a-zA-Z_-.]+[^:]+:.*##[^#].*?$$)|(^##[^#])' $(MAKEFILE_LIST) \
	| awk 'BEGIN {FS = "## "}; \
		{ \
			split($$1, command, ":"); \
			target=command[2]; \
			description=$$2; \
			space=""; \
			if (target && target!="##")\
				printf "\033[32m %-30s \033[0m%s\n", target, description; \
			else \
				printf "\033[33m%s\n%s\n", space, description; \
		}'
