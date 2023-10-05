#!/bin/bash
composer install
docker compose up -d --build
docker compose cp init/init-db.sh mysql:/
docker compose cp init/init-db.sql mysql:/
docker compose exec mysql ./init-db.sh
docker compose exec php bin/console doctrine:migrations:migrate
docker compose exec php bin/console doctrine:fixtures:load --purger axeta --purge-with-truncate
echo 'Initialization completed.';
