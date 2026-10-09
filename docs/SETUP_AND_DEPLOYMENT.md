# Setup and Deployment

This document explains how to install, run, and deploy the e-commerce platform.

## Requirements

- PHP 8.2+
- Composer
- Node.js 18+ and npm
- MySQL or compatible database
- Docker and Docker Compose (optional)

## Local Setup

1. Clone the repository:
```bash
git clone <repo-url>
cd e-commerce-platform
```

2. Copy environment settings:
```bash
cp .env.example .env
```

3. Install PHP dependencies:
```bash
composer install
```

4. Install frontend dependencies:
```bash
npm install
```

5. Generate app key:
```bash
php artisan key:generate
```

6. Configure database credentials in `.env`.

7. Run migrations and seeders:
```bash
php artisan migrate --seed
```

8. Build frontend assets:
```bash
npm run build
```

9. Serve the application locally:
```bash
php artisan serve
```

## Docker Setup

If you prefer Docker, use the provided `docker-compose.yml`.

1. Build and start containers:
```bash
docker compose up -d --build
```

2. Run migrations inside the PHP container:
```bash
docker compose exec app php artisan migrate --seed
```

3. Compile assets if needed:
```bash
docker compose exec app npm install
docker compose exec app npm run build
```

## Environment Variables

Key `.env` values:
- `APP_NAME`
- `APP_ENV`
- `APP_KEY`
- `APP_URL`
- `DB_HOST`
- `DB_PORT`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`
- `SANCTUM_STATEFUL_DOMAINS`
- `SESSION_DOMAIN`

## Deployment

1. Push code to the production server.
2. Install dependencies:
```bash
composer install --optimize-autoloader --no-dev
npm install
npm run build
```
3. Set `.env` and generate app key:
```bash
php artisan key:generate
```
4. Run migrations:
```bash
php artisan migrate --force
```
5. Clear caches:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Notes

- Use a supervised process manager (e.g. Supervisor, systemd) for queue workers if background jobs are needed.
- Ensure proper file permissions for `storage` and `bootstrap/cache`.
- Use HTTPS in production.
- Keep API tokens and secret keys secure.
