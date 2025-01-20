
start:
	symfony server:start --daemon
	docker compose up -d

stop:
	symfony server:stop
	docker compose stop

install: vendor

vendor:
	symfony composer install

reset-db:
	symfony console --env=dev doctrine:database:drop --no-interaction --if-exists --force
	symfony console --env=dev doctrine:database:create --no-interaction --if-not-exists
	rm migrations/Version*
	symfony console --env=dev doctrine:migration:diff --no-interaction --formatted
	mv migrations/Version*.php migrations/Version20250113000000.php
	sed -i -r 's/class Version202[[:digit:]]+ /class Version20250113000000 /g' migrations/Version20250113000000.php
	symfony console --env=dev doctrine:migrations:migrate --no-interaction

db:
	symfony console --env=dev doctrine:database:drop --no-interaction --if-exists --force
	symfony console --env=dev doctrine:database:create --no-interaction --if-not-exists
	symfony console --env=dev doctrine:migrations:migrate --no-interaction
	symfony console --env=dev doctrine:migration:diff --no-interaction --formatted || echo "  ➡ No migration needed 👌"

test-db:
	symfony console --env=test doctrine:database:drop --no-interaction --if-exists --force
	symfony console --env=test doctrine:database:create --no-interaction --if-not-exists
	symfony console --env=test doctrine:migrations:migrate --no-interaction
	symfony console --env=test doctrine:fixtures:load --no-interaction

fixtures:
	symfony console --env=dev doctrine:fixtures:load --no-interaction
