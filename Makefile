
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
	symfony console doctrine:database:drop --no-interaction --if-exists --force
	symfony console doctrine:database:create --no-interaction --if-not-exists
	symfony console doctrine:migrations:migrate --no-interaction
	symfony console doctrine:migration:diff --no-interaction --formatted || echo "  ➡ No migration needed 👌"

fixtures:
	symfony console doctrine:fixtures:load --no-interaction
