#!/usr/bin/env bash

# $ . .bash_aliases # active aliases

alias _DC="docker-compose"
alias _APP="_DC exec app"
alias _PHP="_APP php"
alias _SYMFONY="_PHP bin/console"
alias _COMPOSER="_APP composer"
alias _PHPUNIT="_APP ./vendor/bin/simple-phpunit"

alias reload=". .bash_aliases"

alias sf="_SYMFONY"
alias cc="_SYMFONY cache:clear"
alias composer="_COMPOSER"

alias tests="_PHPUNIT"
alias tests-coverage='_PHPUNIT --coverage-html var/artefacts/phpunit/coverage'
alias tests-watch="_PHP vendor/bin/phpunit-watcher watch"
alias open-coverage="gvfs-open var/artefacts/phpunit/coverage"

alias t="tests"
alias tc='tests-coverage'
alias tw='tests-watch'
alias ut="make unit-tests"
alias ft="make functional-tests"

alias chownfix="_DC run --rm app chown -R $(id -u):$(id -g) ."

echo -e '\033[1;42mAliases loaded\033[0m'