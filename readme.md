
Install
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

php bin/console doctrine:database:create --env=test
php bin/console doctrine:migrations:migrate -n --env=test

php bin/console generate:logs 1000
