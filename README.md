# Task Manager - Backend API

Backend API untuk aplikasi Task Manager menggunakan Laravel 10.

## Tech Stack

- **PHP** 8.1+
- **Laravel** 10
- **MySQL** 8.0
- **Laravel Sanctum** (Token-based Authentication)

## Fitur

- User Authentication (Register, Login, Logout)
- CRUD Tasks (Create, Read, Update, Delete)
- Task ownership (setiap user hanya bisa akses task miliknya)
- Token-based API authentication

## Setup

```bash
# Install dependencies
composer install

# Setup environment
cp .env.example .env
php artisan key:generate

# Konfigurasi database di file .env
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=task_manager
# DB_USERNAME=root
# DB_PASSWORD=

# Jalankan migration & seeder
php artisan migrate --seed

# Jalankan server
php artisan serve
```

## Test Account

```
Email: test@test.com
Password: password
```

## API Endpoints

### Authentication

| Method | Endpoint       | Keterangan       | Auth |
|--------|---------------|-----------------|------|
| POST   | /api/register | Register user   | No   |
| POST   | /api/login    | Login user      | No   |
| POST   | /api/logout   | Logout user     | Yes  |
| GET    | /api/me       | Get current user| Yes  |

### Tasks

| Method | Endpoint        | Keterangan      | Auth |
|--------|----------------|-----------------|------|
| GET    | /api/tasks     | List all tasks  | Yes  |
| POST   | /api/tasks     | Create task     | Yes  |
| GET    | /api/tasks/:id | Get single task | Yes  |
| PUT    | /api/tasks/:id | Update task     | Yes  |
| DELETE | /api/tasks/:id | Delete task     | Yes  |

### Contoh Request

**Login:**
```json
POST /api/login
Content-Type: application/json

{
  "email": "test@test.com",
  "password": "password"
}
```

**Response:**
```json
{
  "user": { "id": 1, "name": "Test User", "email": "test@test.com" },
  "token": "1|abc123..."
}
```

**Create Task:**
```json
POST /api/tasks
Authorization: Bearer <token>
Content-Type: application/json

{
  "title": "Belajar Docker",
  "description": "Memahami containerization",
  "status": "pending"
}
```

## Tugas: Docker

Buatkan konfigurasi Docker untuk backend ini:

1. **Dockerfile** — Gunakan image PHP-FPM Alpine
2. **docker-compose.yml** — Orchestrate backend + MySQL + Nginx
3. **Monitoring** — Tambahkan Prometheus, cAdvisor, dan Grafana

> Lihat branch `complete` untuk referensi jawaban.
