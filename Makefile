SHELL:=/bin/bash

# Inserting Symfony environment variables
# @see https://www.gnu.org/software/make/manual/html_node/Environment.html
# @see https://github.com/symfony/recipes/issues/18
-include .env
-include .env.local

MAKEFILES = .mk/*.mk
include $(sort $(wildcard $(MAKEFILES)))