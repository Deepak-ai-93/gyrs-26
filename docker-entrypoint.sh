#!/bin/sh
set -eu

# Auto-generate APP_KEY if not provided via environment
if [ -z "${APP_KEY:-}" ]; then
    export APP_KEY="base64:$(head -c 32 /dev/urandom | base64)"
    echo "WARNING: APP_KEY not set — generated a random key. Set APP_KEY in Vercel env vars for session persistence." >&2
fi

if [ "${VERCEL_ENV:-preview}" = "production" ]; then
    if [ "${DB_CONNECTION:-}" != "pgsql" ]; then
        echo "Production deployments require DB_CONNECTION=pgsql." >&2
        exit 1
    fi

    if [ -z "${DB_URL:-}${DATABASE_URL:-}" ]; then
        : "${DB_HOST:?DB_HOST or DB_URL must be set for production}"
        : "${DB_DATABASE:?DB_DATABASE must be set for production}"
        : "${DB_USERNAME:?DB_USERNAME must be set for production}"
        : "${DB_PASSWORD:?DB_PASSWORD must be set for production}"
    fi
elif [ "${DB_CONNECTION:-sqlite}" = "sqlite" ]; then
    DB_DATABASE="${DB_DATABASE:-/tmp/gyrs.sqlite}"
    export DB_DATABASE
    mkdir -p "$(dirname "$DB_DATABASE")"

    ready_file="${DB_DATABASE}.ready"
    if [ ! -f "$ready_file" ]; then
        touch "$DB_DATABASE"
        php artisan migrate --force --no-interaction
        php artisan db:seed --force --no-interaction
        touch "$ready_file"
    fi
fi

exec frankenphp run --config /etc/frankenphp/Caddyfile
