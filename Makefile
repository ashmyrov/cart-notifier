up: docker-up
down: docker-down
restart: docker-down docker-up
init: docker-down-clear docker-pull docker-build docker-up symfony-init

php-cli:
	docker exec -it php-cli bash

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

symfony-init: composer-install wait-db migrations ready

composer-install:
	docker-compose run --rm php-cli composer install

wait-db:
	until docker-compose exec -T postgres pg_isready --timeout=0 --dbname=app ; do sleep 1 ; done

migrations:
	docker-compose run --rm php-cli php bin/console doctrine:migrations:migrate --no-interaction

ready:
	docker run --rm -v ${PWD}/src:/app --workdir=/app alpine touch .ready

notify-customers:
	docker-compose run --rm php-cli bin/console app:cart:notify
