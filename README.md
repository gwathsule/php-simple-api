# APi Simples baseada em Clean Architecture

cp .env.example .env
docker-compose up -d
docker-compose exec -it app composer install
docker-compose exec -it app vendor/bin/phpunit  --testdox --coverage-html _reports/coverage/
