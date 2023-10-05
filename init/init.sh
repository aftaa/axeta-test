#!/bin/bash
docker compose cp init-db.sh mysql:/
docker compose cp init-db.sql mysql:/
docker compose exec mysql ./init-db.sh
docker compose exec php bin/console doctrine:migrations:migrate
docker compose exec php bin/console doctrine:fixtures:load --purger axeta --purge-with-truncate
