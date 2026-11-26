#!/bin/sh
set -eu

: "${APP_KEY:?APP_KEY must be set in the Vercel environment}"

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
