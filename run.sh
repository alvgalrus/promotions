#!/bin/bash

docker compose up -d

# If ./vendor doesn't exist, run composer
SCRIPT_DIR="$PWD/${BASH_SOURCE%/*}"
if [ ! -d "${SCRIPT_DIR}/vendor" ]; then
  docker exec -it --user "$(id -u):$(id -g)" promotions_php composer install
fi
