#!/usr/bin/env bash

# $ . .bash_aliases # active aliases

alias _DOCKER_COMPOSE="docker-compose"
alias _EXEC_APP="_DOCKER_COMPOSE exec app"
alias _PHP="_EXEC_APP php"
alias _YARN="_EXEC_APP yarn"
alias _SYMFONY="_PHP bin/console"
alias _COMPOSER="_EXEC_APP composer"
alias _PHPUNIT="_EXEC_APP ./vendor/bin/simple-phpunit"

alias reload=". .bash_aliases"

alias app="_EXEC_APP"
alias php="_PHP"
alias sf="_SYMFONY"
alias cc="_SYMFONY cache:clear"
alias composer="_COMPOSER"
alias yarn="_YARN"

alias tests="_PHPUNIT"
alias tests-coverage='_PHPUNIT --coverage-html var/artefacts/phpunit/coverage'
alias tests-watch="_PHP ./vendor/bin/phpunit-watcher watch"
alias open-coverage="gvfs-open var/artefacts/phpunit/coverage"

alias t="tests --stop-on-error --stop-on-failure --stop-on-warning"
alias tnostop="tests"
alias tc='tests-coverage'
alias tw='tests-watch'
alias ut="make unit-tests"
alias ft="make functional-tests"

alias chownfix="_DOCKER_COMPOSE run --rm app chown -R $(id -u):$(id -g) ."

echo -e '\033[1;42mAliases loaded\033[0m'