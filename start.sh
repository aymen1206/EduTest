#!bin/bash
docker compose -f "docker/docker-compose.yml" up -d 
sleep 4
cat ./theeduke_edu.sql | docker exec -i docker-mysql-1 /usr/bin/mysql -u root --password=theedukeytheedukeytheedukey theeduke_edu 
php artisan serve


