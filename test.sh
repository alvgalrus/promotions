#!/bin/bash

# Check if container is running for tests
RUNNING_CONTAINER="$(docker ps | grep promotions_php)"
if [ -n "${RUNNING_CONTAINER}" ]; then
  docker exec -it --user "$(id -u):$(id -g)" promotions_php php bin/phpunit --colors tests
else
  echo "Container 'promotions_php' isn't running! Please execute './run.sh' first."
fi
