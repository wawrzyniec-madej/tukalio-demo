docker network create --subnet=6.0.0.0/8 shoply_local_network
docker-compose up -d shoply-nginx shoply-php-fpm shoply-mariadb
docker-compose run composer composer install
docker exec shoply-php-fpm php bin/console d:d:c
docker exec shoply-php-fpm php bin/console d:m:m
