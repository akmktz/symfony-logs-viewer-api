##INSTALL
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


##Run tests:
```
php bin/phpunit
```


##Generate test logs
to /tmp/logs:
```
php bin/console generate:logs 1000
```


##Connect to API:
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
http://localhost:8088/api/v1/logs/main_test.log?page=1&per_page=50
```

Sorting
```
http://localhost:8088/api/v1/logs/main_test.log?sort=date_time&order=desc
```

Search
```
http://localhost:8088/api/v1/logs/main_test.log?search=zzz
```

Search by regular expression
```
http://localhost:8088/api/v1/logs/main_test.log?search_type=regex&search=\w{5}://\w{3}\.
```

Period
```
http://localhost:8088/api/v1/logs/main_test.log?from[]=2022-05-05T00:00:00&from[]=2022-05-07T00:00:00&to[]=2022-05-05T23:59:59&to[]=2022-05-07T23:59:59
```

Multiquery
```
http://localhost:8088/api/v1/logs/main_test.log?search_type[]=string&search_type[]=regex&search[]=zzz&search[]=\w{5}://\w{3}\.

http://localhost:8088/api/v1/logs/main_test.log?from[]=2022-05-05T00:00:00&from[]=2022-05-07T00:00:00&to[]=2022-05-05T23:59:59&to[]=2022-05-07T23:59:59

http://localhost:8088/api/v1/logs/main_test.log?from[]=2022-05-05T00:00:00&from[]=2022-05-07T00:00:00&to[]=2022-05-05T23:59:59&to[]=2022-05-07T23:59:59&search_type[]=string&search_type[]=regex&search[]=zzz&search[]=X{4,}
```

_Import posman collection from file_ ```Symfony-logs-viewer.postman_collection.json```

##Database
Database schema in file `DATABASE_SCHEMA.jpg`

_I chose MySQL because I know it well. Other databases would also work, but I didn't have time to explore them._
