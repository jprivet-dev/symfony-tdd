#!/usr/bin/env bash

###> aliases
alias reload=". .bash_aliases"

alias app="docker-compose exec app"
alias composer="app composer"
alias yarn="app yarn"
alias php="app php"
alias phpunit="app ./vendor/bin/simple-phpunit"
alias phpunit-watch="app ./vendor/bin/phpunit-watcher watch"
alias symfony="php bin/console"

alias cc="symfony cache:clear"
alias ccp="symfony cache:clear --env=prod"

alias tests="phpunit --stop-on-error --stop-on-failure --stop-on-warning"
alias tests-no-stop="phpunit"
alias tests-coverage='phpunit --coverage-html build/phpunit/coverage'
alias tests-watch="phpunit-watch"
alias open-coverage="gio open build/phpunit/coverage/index.html"

alias m="make"
alias sf="symfony"
alias t="tests"
alias tnostop="tests-no-stop"
alias tc='tests-coverage; open-coverage'
alias tw='tests-watch'
alias ut="make unit-tests"
alias ft="make functional-tests"

alias chownfix="docker-compose run --rm app chown -R $(id -u):$(id -g) ."

alias project-install="
docker-compose up --remove-orphans -d;
docker-compose exec app composer install --verbose;
docker-compose exec app yarn install;
docker-compose exec app php bin/console doctrine:database:drop --if-exists --force;
docker-compose exec app php bin/console doctrine:database:create;
docker-compose exec app php bin/console doctrine:schema:create;
"
###< aliases

echo -e '\033[1;42msymfony-tdd: aliases loaded\033[0m'