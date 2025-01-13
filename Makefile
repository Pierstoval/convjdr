

install: vendor

vendor:
	symfony composer install

db:
	symfony console doctrine:database:drop --no-interaction --if-exists --force
	symfony console doctrine:database:create --no-interaction --if-not-exists
	rm -rf migrations/*
	symfony console doctrine:migration:diff --no-interaction --formatted
	mv migrations/Version*.php migrations/Version20250113000000.php
	sed -i migrations/Version20250113000000.php -e 's/Version[0-9]\+/Version20250113000000/g'
	symfony console doctrine:migrations:migrate --no-interaction
	symfony console doctrine:fixtures:load --no-interaction
