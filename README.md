# SupSys — Support Ticket System

A Brazilian support ticket management system built with Laravel (backend API) and React (frontend SPA). Designed for managing customer service requests, technician assignments, and client records with Brazilian localization.

---

## Table of Contents

- [Overview](#overview)
- [Tech Stack](#tech-stack)
- [Database Structure](#database-structure)
- [Models & Relationships](#models--relationships)
- [API Endpoints](#api-endpoints)
- [Authentication](#authentication)
- [Frontend Structure](#frontend-structure)
- [Installation (Local)](#installation-local)
- [Installation (Docker)](#installation-docker)
- [Environment Variables](#environment-variables)
- [Running the App](#running-the-app)

---

## Overview

**SupSys** is a web application for managing technical support tickets. It allows teams to:

- Create and track support tickets with statuses (open, in progress, awaiting client, resolved, cancelled)
- Manage clients with Brazilian address data (CEP, CPF/CNPJ, etc.)
- Manage collaborators (technicians, analysts, managers) and assign them to tickets
- Restrict user management to admin roles
- Interact via a modern React SPA authenticated through Laravel Sanctum

---

## Tech Stack

### Backend

| Technology | Version |
|---|---|
| PHP | 8.4+ |
| Laravel | 11.x |
| MySQL | 8.0.33 |
| Laravel Sanctum | 4.0+ |
| Laravel Breeze | (auth scaffolding) |
| PT-BR Validator | (Brazilian validation rules) |

### Frontend

| Technology | Version |
|---|---|
| React | 18.3.1 |
| TypeScript | 5.0+ |
| Vite | 5.0+ |
| Tailwind CSS | 4.1.12 |
| React Router | 7.13+ |
| React Hook Form | 7.55.0 |
| Radix UI | (component library) |
| Lucide React | 0.487.0 |
| Recharts | 2.15.2 |
| React DnD | 16.0.1 |
| Sonner (toasts) | 2.0.3 |
| Axios | 1.1.2 |

### Infrastructure

| Technology | Purpose |
|---|---|
| Docker + Docker Compose | Containerization |
| Nginx | Web server (inside container) |
| PHP-FPM 8.2 | PHP process manager |
| Supervisor | Process manager (PHP-FPM + Nginx) |
| Node.js 20 | Frontend asset build (Docker only) |

---

## Database Structure

The application uses **MySQL 8.0.33**. Migrations are in `database/migrations/`.

### `users`

| Column | Type | Notes |
|---|---|---|
| id | bigint PK | |
| name | string(255) | |
| email | string(255) | unique |
| admin | tinyint | `0` = regular user, `1` = admin |
| email_verified_at | timestamp | nullable |
| password | string(255) | bcrypt hashed |
| remember_token | string | nullable |
| created_at / updated_at | timestamps | |

### `clients`

| Column | Type | Notes |
|---|---|---|
| id | bigint PK | |
| name | string(255) | required |
| company_name | string(255) | nullable |
| cpf_cnpj | bigint | nullable — Brazilian CPF or CNPJ |
| email | string(255) | nullable |
| phone | bigint | nullable |
| address_public_place | string(255) | nullable — Logradouro |
| address_number | string(255) | nullable |
| address_complement | string(255) | nullable |
| address_zip_code | bigint | nullable — CEP |
| address_neighborhood | string(255) | nullable — Bairro |
| address_city | string(255) | nullable — Cidade |
| address_state | string(255) | nullable — Estado (2-char code) |
| created_at / updated_at | timestamps | |

### `collaborators`

| Column | Type | Notes |
|---|---|---|
| id | bigint PK | |
| name | string(255) | required |
| cpf_cnpj | bigint | nullable |
| email | string(255) | nullable |
| type | integer | `0` = technician/analyst, `1` = manager |
| created_at / updated_at | timestamps | |

### `supports`

| Column | Type | Notes |
|---|---|---|
| id | bigint PK | |
| opening_date | date | required |
| status | integer | `0/1` = open, `2` = in_progress, `3` = awaiting_client, `4` = resolved, `5` = cancelled |
| client_id | bigint FK | → `clients.id`, required |
| primary_collaborator_id | bigint FK | → `collaborators.id`, nullable |
| secondary_collaborator_id | bigint FK | → `collaborators.id`, nullable |
| requester_id | bigint FK | → `collaborators.id`, nullable |
| start_datetime | datetime | nullable — scheduled start |
| address | text | nullable — JSON-encoded address override |
| description | text | nullable |
| solution | text | nullable |
| created_at / updated_at | timestamps | |

### Other Standard Tables

| Table | Purpose |
|---|---|
| `password_reset_tokens` | Password reset flow |
| `failed_jobs` | Queue failure tracking |
| `personal_access_tokens` | Sanctum API tokens |

---

## Models & Relationships

All models are in `app/Models/`.

### `User`
- **Fillable**: `name`, `email`, `password`
- **Hidden**: `password`, `remember_token`
- **Traits**: `HasApiTokens`, `HasFactory`, `Notifiable`

### `Client`
- **Fillable**: `name`, `company_name`, `cpf_cnpj`, `email`, `phone`, `address_public_place`, `address_number`, `address_complement`, `address_zip_code`, `address_neighborhood`, `address_city`, `address_state`

### `Collaborator`
- **Fillable**: `name`, `cpf_cnpj`, `email`, `type`, `created_at`

### `Support`
- **Fillable**: `opening_date`, `status`, `primary_collaborator_id`, `secondary_collaborator_id`, `start_datetime`, `client_id`, `address`, `requester_id`, `description`, `solution`
- **Casts**: `address` → `array` (JSON stored in `text` column)
- **Relationships**:
  - `client()` → `HasOne(Client, 'id', 'client_id')`
  - `primary_collaborator()` → `HasOne(Collaborator, 'id', 'primary_collaborator_id')`
  - `secondary_collaborator()` → `HasOne(Collaborator, 'id', 'secondary_collaborator_id')`
  - `requester()` → `HasOne(Collaborator, 'id', 'requester_id')`

---

## API Endpoints

All API routes require `auth:sanctum` authentication. The prefix is `/api/`.

### Supports

| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/supports` | List all tickets (with client, collaborators, requester eager-loaded) |
| POST | `/api/supports` | Create a ticket |
| GET | `/api/supports/{id}` | Get a ticket |
| PATCH | `/api/supports/{id}` | Update a ticket (partial) |
| DELETE | `/api/supports/{id}` | Delete a ticket |

### Clients

| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/clients` | List all clients (ordered by name) |
| POST | `/api/clients` | Create a client |
| GET | `/api/clients/{id}` | Get a client |
| PATCH | `/api/clients/{id}` | Update a client (partial) |
| DELETE | `/api/clients/{id}` | Delete a client |

### Collaborators

| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/collaborators` | List all collaborators |
| POST | `/api/collaborators` | Create a collaborator |
| GET | `/api/collaborators/{id}` | Get a collaborator |
| PATCH | `/api/collaborators/{id}` | Update a collaborator (partial) |
| DELETE | `/api/collaborators/{id}` | Delete a collaborator |

### Users (admin only)

| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/users` | List all users |
| POST | `/api/users` | Create a user |
| GET | `/api/users/{id}` | Get a user |
| PATCH | `/api/users/{id}` | Update a user (partial; password optional) |
| DELETE | `/api/users/{id}` | Delete a user |

### Auth

| Method | Endpoint | Description |
|---|---|---|
| GET | `/api/user` | Get authenticated user |
| POST | `/login` | Authenticate (session) |
| POST | `/logout` | Log out |
| POST | `/forgot-password` | Send reset link |
| POST | `/reset-password` | Reset password |

---

## Authentication

- **Session-based** (`web` guard): used by the SPA (cookie + CSRF)
- **Token-based** (`sanctum`): used for API requests
- **Admin guard**: custom `Admin` middleware (`app/Http/Middleware/Admin.php`) checks `users.admin = 1`; applied to the `/api/users` resource

---

## Frontend Structure

The frontend is a React SPA served from `resources/views/spa.blade.php` for all authenticated routes.

```
resources/js/
├── app.tsx                      # App entry point, router setup
├── lib/
│   └── api.ts                   # Axios API client
├── app/
│   ├── context/
│   │   └── AppContext.tsx        # Global state
│   ├── pages/
│   │   ├── Dashboard
│   │   ├── TicketsList / TicketDetail / TicketForm
│   │   ├── ClientsList / ClientDetail / ClientForm
│   │   ├── CollaboratorsList
│   │   └── Settings
│   ├── components/
│   │   └── Sidebar, ...
│   └── data/
│       └── types.ts              # TypeScript type definitions
└── styles/
    ├── index.css
    ├── theme.css
    ├── tailwind.css
    └── fonts.css
```

---

## Installation (Local)

### Prerequisites

- PHP 8.2+
- Composer
- Node.js 20+ and npm
- MySQL 8.0+

### Steps

```bash
# 1. Clone the repository
git clone <repo-url>
cd sup_sys

# 2. Install PHP dependencies
composer install

# 3. Install JS dependencies
npm install

# 4. Copy and configure the environment file
cp .env.example .env

# Edit .env with your database credentials:
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=supsys
# DB_USERNAME=root
# DB_PASSWORD=your_password

# 5. Generate the application key
php artisan key:generate

# 6. Run database migrations
php artisan migrate

# 7. (Optional) Seed the database with a default admin user
php artisan db:seed

# 8. Build frontend assets
npm run build
# or for development with hot reload:
npm run dev

# 9. Start the Laravel development server
php artisan serve
```

The app will be available at `http://localhost:8000`.

---

## Installation (Docker)

### Prerequisites

- Docker
- Docker Compose

### Steps

```bash
# 1. Clone the repository
git clone <repo-url>
cd sup_sys

# 2. Copy and configure the environment file
cp .env.example .env

# Edit .env — set these for Docker:
# DB_HOST=supsys_db
# DB_PORT=3306
# DB_DATABASE=supsys
# DB_USERNAME=supsys_user
# DB_PASSWORD=supsys_pass

# 3. Start the containers
docker compose up --build -d
```

The app will be available at `http://localhost:8001`.

The container entrypoint automatically:
1. Generates `APP_KEY` if not set
2. Waits for MySQL to be healthy
3. Runs `php artisan migrate`
4. Caches routes, config, and views
5. Starts PHP-FPM and Nginx via Supervisor

### Docker Services

| Service | Image | Port |
|---|---|---|
| `supsys_app` | Custom (PHP 8.2-FPM + Nginx) | `8001:8080` |
| `supsys_db` | `mysql:8.0.33` | internal only |

### Volumes

| Volume | Mount | Purpose |
|---|---|---|
| `supsys_db` | MySQL data dir | Database persistence |
| `./storage` | `/var/www/html/storage` | Logs and uploads |
| `./.env` | `/var/www/html/.env` | App config |

---

## Environment Variables

| Variable | Required | Default | Description |
|---|---|---|---|
| `APP_NAME` | yes | `Laravel` | Application display name |
| `APP_ENV` | yes | `local` | `local` or `production` |
| `APP_KEY` | yes | — | Generated by `artisan key:generate` |
| `APP_DEBUG` | yes | `true` | Show debug errors |
| `APP_URL` | yes | `http://localhost` | Base URL |
| `DB_CONNECTION` | yes | `mysql` | Database driver |
| `DB_HOST` | yes | `127.0.0.1` | Database host (`supsys_db` in Docker) |
| `DB_PORT` | yes | `3306` | Database port |
| `DB_DATABASE` | yes | `laravel` | Database name |
| `DB_USERNAME` | yes | `root` | Database user |
| `DB_PASSWORD` | yes | — | Database password |
| `SESSION_DRIVER` | yes | `file` | `file`, `cookie`, `database` |
| `SESSION_LIFETIME` | yes | `120` | Session lifetime in minutes |
| `CACHE_DRIVER` | no | `file` | Cache backend |
| `QUEUE_CONNECTION` | no | `sync` | Queue driver |
| `MAIL_MAILER` | no | `smtp` | Mail driver |
| `APP_ADMIN_PW` | no | `123456789` | Default admin password used by seeder |

---

## Running the App

### Development

```bash
# Run both backend and frontend dev servers concurrently
php artisan serve &
npm run dev
```

### Production (Docker)

```bash
docker compose up -d
```

### Useful Artisan Commands

```bash
# Clear all caches
php artisan optimize:clear

# Re-cache for production
php artisan optimize

# Run migrations fresh (drops all tables)
php artisan migrate:fresh

# Run migrations with seeders
php artisan migrate --seed

# Open interactive REPL
php artisan tinker
```
