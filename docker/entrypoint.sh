#!/bin/sh
set -e

php artisan storage:link || true

if [ "${RUN_MIGRATIONS:-false}" = "true" ]; then
	php artisan migrate --force
fi

exec "$@"
