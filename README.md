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


###Connect to API:
Logs list
```
http://localhost:8088/api/v1/logs
```

Show log items
```
http://localhost:8088/api/v1/logs/<logfile name>
```

Pagination
```
http://localhost:8088/api/v1/logs/test1.log?page=1&per_page=50
```

Sorting
```
http://localhost:8088/api/v1/logs/test1.log?sort=date_time&order=desc
```

Search
```
http://localhost:8088/api/v1/logs/test1.log?search=zzz
```

Search by regular expression
```
http://localhost:8088/api/v1/logs/test1.log?search_type=regex&search=\w{5}://\w{3}\.
```
