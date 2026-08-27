#!/usr/bin/env bash
set -euo pipefail

cd /var/www/html

php artisan storage:link --force >/dev/null 2>&1 || true

php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

exec "$@"
