# Promotions task

## How to launch
You can check some parameters in the `docker-compose.yml` file. Default data is stored in the `/data/products.json` file.
*Check execution permissions before running!*
> ./run.sh

The project should launch here by default: http://localhost:8000/products

## Testing
The following command needs the project to be running already.
> ./test.sh

## Considerations
* The project runs on PHP 8.3+ (minimum) and Symfony 7 (it can be downgraded to PHP 8.2 by removing const types, though).
  * I've upgraded PHPUnit to version 11.2+ from default 9.5 in order to mock readonly classes:
    https://github.com/mockery/mockery/issues/1317#issuecomment-2400944985
* Docker is required, some modifications might be needed if you don't have a bash-compatible shell.
  * An alternative might to just run `docker compose up -d` and then `docker exec -it --user "$(id -u):$(id -g)" promotions_php composer install`.
  * Or modify the `Dockerfile` so it copies the project before `RUN composer install`
* I chose to simplify data acquisition, but alternative implementations of `ProductReader` can use other data sources like Redis or relational databases.
  * Preloading might be done at container initialization time, in such case.
* I used DTOs to simplify data exchange, considering Daniel Leech's observations here:
  https://www.dantleech.com/blog/2024/12/28/php-dtos-c-dto-and-you/#no-entity-serialization
* **Testing:**
  * Most testcases are inside unit tests, except controller tests which are functional.
  * Tests don't rely on the `/data/` folder, a `FileReaderFake` is provided and injected via `/config/services_test.yaml`.
