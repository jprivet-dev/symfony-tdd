#!/usr/bin/env bash

# $ . .bash_aliases # active aliases

alias app="docker-compose exec app"
alias php="app php"
alias sf="app bin/console"
alias composer="app composer"

alias cc="sf cache:clear"

#alias tests="app ./bin/phpunit"
alias tests="php bin/phpunit"
alias tests-coverage='tests --coverage-html var/artefacts/phpunit/coverage'
alias open-coverage="gvfs-open var/artefacts/phpunit/coverage"
alias t="tests"
alias tc='tests-coverave'

alias ut="make unit-tests"
alias ft="make functional-tests"

alias chownfix="docker-compose run --rm app chown -R $(id -u):$(id -g) ."