APP_CONTAINER_NAME := api-app
docker_compose_bin := $(shell command -v docker-compose 2> /dev/null)

run:
	$(docker_compose_bin) up --no-recreate -d
	$(docker_compose_bin) exec "$(APP_CONTAINER_NAME)" composer install --no-interaction --ansi --no-suggest
	$(docker_compose_bin) exec "$(APP_CONTAINER_NAME)" php artisan migrate --force --no-interaction -vvv
	$(docker_compose_bin) exec "$(APP_CONTAINER_NAME)" php artisan db:seed --force -vvv
	$(docker_compose_bin) exec "$(APP_CONTAINER_NAME)" vendor/phpunit/phpunit/phpunit --configuration /app/phpunit.xml /app/tests/