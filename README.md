# FMK Schools Website

The website for Future Model of Knowledge Schools (Lagos, Nigeria), built on Laravel with Filament as the admin panel.

## Stack

- Laravel 13 (PHP 8.3)
- Filament 5 — admin panel at `/admin`, used to manage News & Events posts
- Blade templates, Tailwind CSS v4, Alpine.js
- SQLite (dev) — see `.env` for the active connection

## Local setup

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
php artisan make:filament-user
composer dev
```

`composer dev` runs the Laravel dev server, queue listener, log tailer, and Vite together.

## Admin panel

Manage News & Events posts at `/admin`. Create an admin login locally with:

```bash
php artisan make:filament-user
```

## Deployment

Deployed via cPanel Git Version Control on shared hosting (`.cpanel.yml` defines the deploy tasks: migrate, storage:link, config:cache, view:clear). `vendor/` and `public/build/` are committed to the repo since Composer isn't run on the server.
