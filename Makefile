start:
	docker compose up -d

composer-install:
	docker compose exec php composer install

ecs-fix:
	docker compose exec php vendor/bin/ecs check --fix

phpstan:
	docker compose exec php vendor/bin/phpstan analyse -l 8 src tests

run-tests:
	docker compose exec php vendor/phpunit/phpunit/phpunit

start-with-logs:
	docker compose up