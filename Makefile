init: docker-down-clear \
	docker-pull docker-build docker-up
up: docker-up
down: docker-down
restart: down up
rebuild: docker-down docker-build docker-up

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull --include-deps

docker-build:
	docker-compose build

up:
	docker-compose up -d

down:
	docker-compose down --remove-orphans

restart: down up

api-permissions:
	docker run --rm -v ${PWD}/api:/srv/api -w /srv/api alpine chmod 777 -R .

api-composer-install:
	docker-compose run --rm api-php-cli composer install

front-watch:
	docker-compose run --rm front-node npm run start:dev

keller-oauth-keys:
	docker-compose run --rm php mkdir -p var/oauth
	docker-compose run --rm php openssl genrsa -out var/oauth/private.key 2048
	docker-compose run --rm php openssl rsa -in var/oauth/private.key -pubout -out var/oauth/public.key
	docker-compose run --rm php chmod 644 var/oauth/private.key var/oauth/public.key

keller-oauth-add-client:
	docker-compose run --rm php php bin/console trikoder:oauth2:create-client

docs:
	docker-compose run --rm php php bin/console api:docs

update-schema:
	docker-compose run --rm php php bin/console doctrine:schema:update --force

mi-di:
	docker-compose run --rm php php bin/console doctrine:migrations:diff

mi-mi:
	docker-compose run --rm php php bin/console doctrine:migrations:migrate

mi-fi:
	docker-compose run --rm php php bin/console doctrine:fixtures:load --no-interaction



build-prod:
	docker build --pull --file=front/docker/production/node.docker --tag registry.gitlab.com/ilyakara/keller/front-node:latest front
	docker build --pull --file=gateway/docker/production/nginx.docker --tag registry.gitlab.com/ilyakara/keller/gateway:latest gateway
	docker build --pull --file=api/docker/production/nginx.docker --tag registry.gitlab.com/ilyakara/keller/nginx:latest api
	docker build --pull --file=api/docker/production/php-fpm/Dockerfile --tag registry.gitlab.com/ilyakara/keller/api-php-fpm:latest api
	docker build --pull --file=api/docker/production/php-cli/Dockerfile --tag registry.gitlab.com/ilyakara/keller/api-php-cli:latest api
	docker build --pull --file=api/docker/production/postgres.docker --tag registry.gitlab.com/ilyakara/keller/postgres:latest api
	docker build --pull --file=api/docker/production/redis.docker --tag registry.gitlab.com/ilyakara/keller/redis:latest api
	docker build --pull --file=storage/docker/production/nginx.docker --tag registry.gitlab.com/ilyakara/keller/storage:latest storage
	docker build --pull --file=front/docker/production/nginx.docker --tag registry.gitlab.com/ilyakara/keller/front:latest front

push-prod:
	docker push registry.gitlab.com/ilyakara/keller/front-node:latest
	docker push registry.gitlab.com/ilyakara/keller/gateway:latest
	docker push registry.gitlab.com/ilyakara/keller/nginx:latest
	docker push registry.gitlab.com/ilyakara/keller/api-php-cli:latest
	docker push registry.gitlab.com/ilyakara/keller/api-php-fpm:latest
	docker push registry.gitlab.com/ilyakara/keller/postgres:latest
	docker push registry.gitlab.com/ilyakara/keller/redis:latest
	docker push registry.gitlab.com/ilyakara/keller/storage:latest
	docker push registry.gitlab.com/ilyakara/keller/front:latest

deploy:
	ssh -o StrictHostKeyChecking=no root@89.223.120.90 'rm -rf docker-compose.yml .env'
	scp -o StrictHostKeyChecking=no docker-compose.prod.yml root@89.223.120.90:docker-compose.yml
	scp -o StrictHostKeyChecking=no .env.prod root@89.223.120.90:.env
	ssh -o StrictHostKeyChecking=no root@89.223.120.90 'docker login registry.gitlab.com'
	ssh -o StrictHostKeyChecking=no root@89.223.120.90 'docker-compose pull'
	ssh -o StrictHostKeyChecking=no root@89.223.120.90 'docker-compose up --build -d'
	ssh -o StrictHostKeyChecking=no root@89.223.120.90 'until docker-compose exec -T db pg_isready --timeout=0 --dbname=app ; do sleep 1 ; done'
	ssh -o StrictHostKeyChecking=no root@89.223.120.90 'docker-compose run --rm api-php-cli bin/console doctrine:migrations:migrate --no-interaction'
	ssh -o StrictHostKeyChecking=no root@89.223.120.90 'docker image prune'

release: build-prod push-prod deploy