###INSTALL
Install packages:
```
composer install
```

Run docker compose to run application and database 
```
docker-compose up
```


Init database:
```
php bin/console install && php bin/console install --env=test
```
 or
```
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate -n
php bin/console doctrine:database:create --env=test
php bin/console doctrine:migrations:migrate -n --env=test
```


###Run tests:
```
php bin/phpunit
```


###Generate test logs
to /tmp/logs:
```
php bin/console generate:logs 1000
```
