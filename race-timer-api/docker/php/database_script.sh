#!/bin/sh
set -e

# Čekaj da se baza digne
until php bin/console doctrine:query:sql "SELECT 1" > /dev/null 2>&1; do
  echo "Waiting for database to be ready..."
  sleep 2
done

# Pokreni migracije (ignoriraj greške ako tablice već postoje)
echo "Running migrations..."
if ! php bin/console doctrine:migrations:migrate --no-interaction; then
    echo "Migration failed (possibly due to existing tables). Continuing anyway..."
fi

# Učitaj fixtures ako je postavljena varijabla LOAD_FIXTURES=true
if [ "$LOAD_FIXTURES" = "true" ]; then
    echo "Loading fixtures..."
    php bin/console doctrine:fixtures:load --no-interaction
fi

# Pokreni glavni proces (ako se koristi u Dockerfile-u kao entrypoint)
exec docker-php-entrypoint "$@"
