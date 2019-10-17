##
## PROJECT
## -------
##

.PHONY: start
start: docker.start ready ## Start the project

.PHONY: stop
stop: docker.stop ## Stop the project

.PHONY: tests
tests: phpunit.all ## Launch all tests

.PHONY: ready
ready:
	@echo -e "\033[1;42m"
	@echo -e "READY!"
	@echo -e "Open \e[4m$(LOCALHOST)\033[0m"
	@echo