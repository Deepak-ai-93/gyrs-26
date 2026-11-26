FROM node:24-alpine AS assets

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci --ignore-scripts

COPY resources ./resources
COPY vite.config.js ./
COPY public ./public
RUN npm run build

FROM dunglas/frankenphp:1-php8.4-bookworm AS base

RUN cp "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
    && install-php-extensions intl zip pdo_pgsql pdo_sqlite

WORKDIR /app

FROM base AS dependencies

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --no-scripts \
    --optimize-autoloader \
    --prefer-dist

COPY . .
RUN mkdir -p \
        storage/framework/cache \
        storage/framework/sessions \
        storage/framework/views \
        bootstrap/cache \
    && composer dump-autoload --no-dev --classmap-authoritative

FROM base AS runtime

COPY --from=dependencies /app /app
COPY --from=assets /app/public/build /app/public/build
COPY Caddyfile /etc/frankenphp/Caddyfile
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint

RUN chmod +x /usr/local/bin/docker-entrypoint \
    && chmod -R 775 /app/storage /app/bootstrap/cache \
    && mkdir -p /config/caddy /data/caddy

ENV PORT=80 \
    APP_NAME="GYRS Portal" \
    APP_ENV=production \
    APP_DEBUG=false \
    LOG_CHANNEL=stderr \
    CACHE_STORE=array \
    SESSION_DRIVER=cookie \
    QUEUE_CONNECTION=sync \
    DB_CONNECTION=sqlite \
    DB_DATABASE=/tmp/gyrs.sqlite \
    VIEW_COMPILED_PATH=/tmp/framework/views

EXPOSE 80

CMD ["/usr/local/bin/docker-entrypoint"]
