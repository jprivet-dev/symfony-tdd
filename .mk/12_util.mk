## UTIL

.PHONY: util.readme.update
util.readme.update: .mk/bin/util-readme-update ## Util (Readme.adoc): Retrieve and insert the latest makefile commands & aliases in the Readme.adoc.
	. .mk/bin/util-readme-update


.PHONY: util.php.strict
util.php.strict: .mk/bin/util-php-strict ## Util (PHP): Insert `<?php declare(strict_types=1);` instead of `<?php` in all PHP files in src/ & tests/ folders.
	. .mk/bin/util-php-strict