#!/usr/bin/env bash

# $ . .bash_aliases # active aliases
alias reload=". .bash_aliases"

alias _DOCKER_COMPOSE="docker-compose"
alias _EXEC_APP="_DOCKER_COMPOSE exec app"
alias _COMPOSER="_EXEC_APP composer"
alias _YARN="_EXEC_APP yarn"
alias _PHP="_EXEC_APP php"
alias _PHPUNIT="_EXEC_APP ./vendor/bin/simple-phpunit"
alias _PHPUNIT_WATCH="_EXEC_APP ./vendor/bin/phpunit-watcher watch"
alias _SYMFONY="_PHP bin/console"

alias app="_EXEC_APP"
alias composer="_COMPOSER"
alias yarn="_YARN"
alias php="_PHP"
alias sf="_SYMFONY"
alias cc="_SYMFONY cache:clear"
alias ccp="_SYMFONY cache:clear --env=prod"

alias tests="_PHPUNIT --stop-on-error --stop-on-failure --stop-on-warning"
alias tests-no-stop="_PHPUNIT"
alias tests-coverage='_PHPUNIT --coverage-html build/phpunit/coverage'
alias tests-watch="_PHPUNIT_WATCH"
alias open-coverage="gio open build/phpunit/coverage/index.html"

alias t="tests"
alias tnostop="tests-no-stop"
alias tc='tests-coverage; open-coverage'
alias tw='tests-watch'
alias ut="make unit-tests"
alias ft="make functional-tests"

alias chownfix="_DOCKER_COMPOSE run --rm app chown -R $(id -u):$(id -g) ."

echo -e '\033[1;42msymfony-tdd: aliases loaded\033[0m'