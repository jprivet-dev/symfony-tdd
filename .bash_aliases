#!/usr/bin/env bash

# $ . .bash_aliases # active aliases

alias app="docker-compose exec app"
alias php="app php"
alias sf="app bin/console"
alias composer="app composer"

#alias tests="app ./bin/phpunit"
alias tests="app ./vendor/bin/simple-phpunit"
alias t="tests"

alias ut="make unit-tests"
alias ft="make functional-tests"

alias chownfix="docker-compose run --rm app chown -R $(id -u):$(id -g) ."