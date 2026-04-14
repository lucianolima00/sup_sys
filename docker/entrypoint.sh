#!/usr/bin/env bash
set -e

DB_HOST="${DB_HOST:-mysql}"
DB_PORT="${DB_PORT:-3306}"

# Generate APP_KEY if not set
if [ -z "$APP_KEY" ]; then
    echo "Generating application key..."
    php /var/www/html/artisan key:generate --force --no-ansi
    APP_KEY=$(grep "^APP_KEY=" /var/www/html/.env | cut -d'=' -f2-)
    export APP_KEY
fi

# Wait for MySQL to accept connections
echo "Waiting for database at ${DB_HOST}:${DB_PORT}..."
until (echo > /dev/tcp/${DB_HOST}/${DB_PORT}) 2>/dev/null; do
    echo "Database not ready, retrying in 3s..."
    sleep 3
done
echo "Database is up."

APP_ENV="${APP_ENV:-production}"

# Run migrations
php /var/www/html/artisan migrate --force --no-ansi

# Cache config/routes/views only in production (caching in dev breaks live changes)
if [ "$APP_ENV" = "production" ]; then
    echo "Production mode: caching config, routes and views..."
    php /var/www/html/artisan config:cache --no-ansi
    php /var/www/html/artisan route:cache --no-ansi
    php /var/www/html/artisan view:cache --no-ansi
else
    echo "Development mode (APP_ENV=${APP_ENV}): skipping cache optimisation"
fi

chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

exec supervisord -c /etc/supervisor/conf.d/supervisord.conf
