##
## PROJECT
## -------
##

.PHONY: start
start: docker.start _ready ## Start the project

.PHONY: stop
stop: docker.stop ## Stop the project

.PHONY: tests
tests: phpunit ## Launch all tests

#
#	"PRIVATE"
#

.PHONY: _build
_build: # Create 'build' folder
	mkdir -p $(FOLDER_BUILD)

.PHONY: _build.clean
_build.clean: # Remove 'build' folder
	rm -rf $(FOLDER_BUILD)

.PHONY: _ready
_ready:
	@echo -e "\033[1;42m"
	@echo -e "READY!"
	@echo -e "Open \e[4m$(LOCALHOST)\033[0m"
	@echo