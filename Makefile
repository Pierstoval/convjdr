
start:
	symfony server:start --daemon
	docker compose up -d

stop:
	symfony server:stop
	docker compose stop

install: vendor

vendor:
	symfony composer install

db:
	symfony console --env=dev doctrine:database:drop --no-interaction --if-exists --force
	symfony console --env=dev doctrine:database:create --no-interaction --if-not-exists
	symfony console --env=dev doctrine:migrations:migrate --no-interaction
	symfony console --env=dev doctrine:migration:diff --no-interaction --formatted || echo "  ➡ No migration needed 👌"

fixtures:
	symfony console --env=dev doctrine:fixtures:load --no-interaction
