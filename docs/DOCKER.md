# Docker development setup

Compose layout matches the dental stack pattern: **nginx** reverse proxy, **app** (Laravel), **queue**, **scheduler**, **MySQL**, **Redis**, and **Mailhog**. No Postgres, PgBouncer, MinIO, or Next.js apps.

## Stack

| Service | Image / build | Default host port |
|---------|----------------|-------------------|
| nginx | `nginx:1.25-alpine` | 8080 |
| app | `ecommerce-platform-app` | — (PHP-FPM) |
| queue | same as app | — |
| scheduler | same as app | — |
| mysql | `mysql:8.0` | 3307 |
| redis | `redis:7-alpine` | 6380 |
| mailhog | `mailhog/mailhog` | 1026 (SMTP), 8026 (UI) |
| phpmyadmin | `phpmyadmin:latest` | 8081 |
| node | `node:22-bookworm-slim` | 5173 (`--profile frontend`) |

Ports are offset so this stack can run alongside the dental project on the same machine.

## Quick start

```bash
cp .env.docker.example .env

docker compose build
docker compose up -d

docker compose exec app composer install
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
docker compose exec app php artisan storage:link
```

- App: http://localhost:8080  
- API docs: http://localhost:8080/docs  
- Mailhog: http://localhost:8026  
- phpMyAdmin: http://localhost:8081  

## Frontend (Vite)

```bash
docker compose --profile frontend up -d node
```

## Layout

```
nginx/conf.d/default.conf   # reverse proxy → app:9000
docker-compose.yml          # services (dental-style sections)
Dockerfile                  # PHP 8.2-FPM + Composer + redis ext
docker/entrypoint.sh
docker/php/conf.d/laravel.ini
```

## Test users

Password: `password` — `admin@example.com`, `seller1@example.com`, `customer@example.com`
