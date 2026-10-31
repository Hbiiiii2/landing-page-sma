#!/bin/sh
set -e

echo "Starting SMA Islam Al-Madinah Application Container..."

# Ensure required directories exist
mkdir -p /var/www/html/storage/framework/sessions \
         /var/www/html/storage/framework/views \
         /var/www/html/storage/framework/cache \
         /var/www/html/storage/app/public \
         /var/www/html/storage/logs \
         /var/www/html/bootstrap/cache

# Remove any stale bootstrap cache files copied from host (e.g. packages.php with dev-only dependencies)
rm -f /var/www/html/bootstrap/cache/*.php

# Re-discover packages for the current vendor directory
php artisan package:discover --ansi || true

# Fix permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Wait for MySQL database if DB_HOST is set and not sqlite
if [ "$DB_CONNECTION" = "mysql" ] || [ "$DB_CONNECTION" = "mariadb" ]; then
    echo "Waiting for database connection at $DB_HOST:${DB_PORT:-3306}..."
    MAX_TRIES=30
    COUNT=0
    until php -r "try { new PDO('mysql:host=' . getenv('DB_HOST') . ';port=' . (getenv('DB_PORT') ?: 3306), getenv('DB_USERNAME'), getenv('DB_PASSWORD')); exit(0); } catch (Exception \$e) { exit(1); }" 2>/dev/null; do
        COUNT=$((COUNT+1))
        if [ $COUNT -ge $MAX_TRIES ]; then
            echo "Database connection timed out after $MAX_TRIES attempts."
            break
        fi
        echo "Database is not ready yet - retrying ($COUNT/$MAX_TRIES)..."
        sleep 2
    done
    echo "Database is ready!"
fi

# Run database migrations and storage symlink only for web/app container
if [ "$1" = "php-fpm" ]; then
    echo "Creating public storage symlink..."
    php artisan storage:link --force || true

    # Generate APP_KEY if missing
    if [ -z "$APP_KEY" ]; then
        echo "APP_KEY is empty, generating application key..."
        php artisan key:generate --force || true
    fi

    echo "Running database migrations..."
    php artisan migrate --force || true

    # Seed initial data on first deployment if not seeded yet
    if [ ! -f /var/www/html/storage/.seeded ]; then
        echo "Seeding initial school data..."
        php artisan db:seed --class=SchoolDataSeeder --force || true
        touch /var/www/html/storage/.seeded || true
    fi

    echo "Publishing Filament assets..."
    php artisan filament:assets || true

    if [ "$APP_ENV" = "production" ]; then
        echo "Clearing stale caches and optimizing for production..."
        php artisan optimize:clear || true
        php artisan config:cache || true
        php artisan route:cache || true
        php artisan view:cache || true
        php artisan event:cache || true
        php artisan filament:cache-components || true
        php artisan tallcms:install || true

    else
        echo "Clearing cache for environment: $APP_ENV..."
        php artisan config:clear || true
        php artisan cache:clear || true
    fi
fi

echo "Application setup completed. Launching: $@"
exec "$@"
