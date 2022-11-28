# APi Simples baseada em Clean Architecture

docker-compose up -d

docker-compose exec -it app composer install

docker-compose exec -it app touch storage/api.db storage/database.log
docker-compose exec -it app chmod a+rw storage storage/*


docker-compose exec -it app vendor/bin/phpunit  --testdox --coverage-html _reports/coverage/
