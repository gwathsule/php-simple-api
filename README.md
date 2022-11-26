# Feira API

docker-compose up -d

docker-compose exec -it app composer install

docker-compose exec -it app vendor/bin/phpunit

vendor/bin/phpunit  --testdox --coverage-html _reports/coverage/