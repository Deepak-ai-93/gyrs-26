# GYRS Portal — Gujarat Youth Rojgar Setu

Official employment portal for the Directorate of Employment & Training,
Government of Gujarat. Laravel 13 + Supabase Postgres.

## Stack

- **Laravel 13** (PHP 8.4) — routing, validation, authorization, Blade views, services.
- **Vite** — CSS/JS build (`resources/css/app.css`, `resources/js/app.js`).
- **Supabase Postgres** in production; **SQLite** for local development.
- **Vercel** container deployment with FrankenPHP.

The original static HTML/CSS/JS prototype is preserved under `prototype/` for
feature/design reference only and is not part of the running application.

## Project structure

```
app/            Controllers (Public/Auth/Candidate/Admin), Models, Requests,
                Policies, Services, Middleware
database/       Migrations, seeders, factories
resources/      Blade views + design-system CSS/JS
routes/web.php  Public, candidate, and admin route groups
Dockerfile      Vercel container image and production asset build
Caddyfile       FrankenPHP web server configuration
docker-entrypoint.sh  Runtime validation and Preview SQLite bootstrap
prototype/      Legacy static prototype (reference only)
.agent/         Design system, migration plan, TODO, build contract
docs/           Product documentation
```

## Local development

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
npm install && npm run build
php artisan serve
```

Dev credentials come from `GYRS_DEV_PASSWORD` (see `config/gyrs.php`); there are
no hardcoded demo credentials or OTP backdoors in the application code.

## Production (Supabase Postgres)

Set the following environment variables (never commit them). Configure
`APP_KEY` for both **Production** and **Preview** deployments in Vercel.
Production also requires the PostgreSQL settings below. Preview deployments
use a seeded SQLite demo database by default; its data is ephemeral. To use
PostgreSQL for previews, configure the database variables in the Preview scope
as well.

```
DB_CONNECTION=pgsql
DB_HOST=db.<project-ref>.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=...
DB_SSLMODE=require
SUPABASE_URL=...
SUPABASE_ANON_KEY=...
SUPABASE_SERVICE_ROLE_KEY=...
APP_KEY=base64:...
```

`SUPABASE_SERVICE_ROLE_KEY` is server-side only and must never reach the browser.

## Deploy on Vercel

The project uses Vercel's current Container runtime with FrankenPHP; it does
not use the archived `vercel-php` runtime. Keep `Dockerfile`, `Caddyfile`,
`.dockerignore`, and `vercel.json` at the project root.

1. Import the repository into Vercel and use the repository root as the project
   root. If this is an existing project with a different framework preset,
   switch its framework preset to **Container**.
2. Generate an application key with `php artisan key:generate --show`. Add the
   result as `APP_KEY` in both the **Production** and **Preview** environment
   scopes. Use a different key for each scope and never commit either key.
3. Configure the **Production** environment with `DB_CONNECTION=pgsql`,
   `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, and
   `DB_SSLMODE=require`. Add the required Supabase variables listed above and
   keep `APP_DEBUG=false`.
4. Apply migrations to the production database before sending traffic:
   `php artisan migrate --force`, using the same production database settings.
   Migrations are intentionally not run against PostgreSQL during container
   startup.
5. Preview deployments default to a seeded SQLite database under `/tmp`. It is
   initialized at container startup and is temporary, isolated per instance,
   and not included in the repository or image. Set Preview's `DB_CONNECTION`
   to `pgsql` and configure its database variables if Preview needs durable
   data.
6. Deploy with the Vercel Git integration or run `vercel deploy --prod` from
   the project root.

The container build installs production Composer dependencies and builds the
Vite assets. Production requires a reachable PostgreSQL database and all
required Vercel environment variables; an upload alone cannot supply database
credentials or an application key.

For candidate SMS verification, configure `TWILIO_ACCOUNT_SID`,
`TWILIO_AUTH_TOKEN`, and either `TWILIO_FROM_NUMBER` or
`TWILIO_MESSAGING_SERVICE_SID`. Configure `AI_API_KEY` to enable provider-backed
résumé analysis; without it, the application uses its local analyser. Google
sign-in also requires `GOOGLE_CLIENT_ID`, `GOOGLE_CLIENT_SECRET`, and a
`GOOGLE_REDIRECT_URI` registered with Google.

> Deployment Protection: disable **Vercel Authentication** in
> Project → Settings → Deployment Protection to make the site publicly reachable.
