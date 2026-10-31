#!/bin/sh
set -e

# Setup writable storage paths in /tmp (vital for Vercel read-only container filesystem)
mkdir -p /tmp/storage/framework/cache/data
mkdir -p /tmp/storage/framework/views
mkdir -p /tmp/storage/framework/sessions
mkdir -p /tmp/storage/logs

# Cache routes and views for faster response times.
# NOTE: config:cache is intentionally NOT run here — env vars are injected at
# runtime by Vercel and must remain readable via env().
if [ -n "$APP_KEY" ]; then
    php artisan route:cache || true
    php artisan view:cache || true
fi

exec frankenphp run --config /app/Caddyfile
