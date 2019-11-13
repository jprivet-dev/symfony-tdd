## UTIL

.PHONY: util.readme.update
util.readme.update: .mk/bin/util-readme-update ## Readme.adoc: Retrieve and insert the latest makefile commands & aliases in the Readme.adoc.
	. .mk/bin/util-readme-update