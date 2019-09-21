#!/usr/bin/env bash

# $ . .bash_aliases # active aliases

alias php="docker-compose exec app php"
alias sf="docker-compose exec app bin/console"
alias composer="docker-compose exec app composer"

alias chownfix="docker-compose run --rm app chown -R $(id -u):$(id -g) ."