# Task Manager - Backend API (Complete)

Backend API untuk aplikasi Task Manager menggunakan Laravel 10, lengkap dengan konfigurasi Docker dan Monitoring.

## Tech Stack

- **PHP** 8.3 (FPM Alpine)
- **Laravel** 10
- **MySQL** 8.0
- **Laravel Sanctum** (Token-based Authentication)
- **Docker** & Docker Compose
- **Nginx** (Alpine) — Reverse proxy
- **Prometheus** — Metrics collection
- **cAdvisor** — Container metrics
- **Grafana** — Dashboard monitoring

## Arsitektur

```
┌─────────────────────────────────────────────────────────┐
│                    Docker Network                        │
│                                                          │
│  ┌──────────┐    ┌──────────┐    ┌──────────────────┐   │
│  │ Frontend │    │  Nginx   │    │    Backend        │   │
│  │ (Vue.js) │───▶│ (Proxy)  │───▶│  (Laravel/PHP)   │   │
│  │ :8080    │    │ :8000    │    │  PHP-FPM :9000    │   │
│  └──────────┘    └──────────┘    └────────┬─────────┘   │
│                                           │              │
│                                    ┌──────▼─────────┐   │
│                                    │     MySQL      │   │
│                                    │     :3307      │   │
│                                    └────────────────┘   │
│                                                          │
│  ┌──────────┐    ┌──────────┐    ┌──────────────────┐   │
│  │ Grafana  │◀───│Prometheus│◀───│    cAdvisor      │   │
│  │ :3001    │    │ :9090    │    │    :8081         │   │
│  └──────────┘    └──────────┘    └──────────────────┘   │
└─────────────────────────────────────────────────────────┘
```

## Port Mapping

| Service    | Port  | Keterangan                    |
|-----------|-------|-------------------------------|
| Frontend  | 8080  | Vue.js app (production)       |
| Frontend  | 5173  | Vue.js dev server             |
| Backend   | 8000  | Laravel API via Nginx         |
| MySQL     | 3307  | Database (mapped dari 3306)   |
| Prometheus| 9090  | Metrics collection            |
| cAdvisor  | 8081  | Container metrics             |
| Grafana   | 3001  | Dashboard monitoring          |

## Quick Start (Docker)

```bash
# 1. Clone kedua repository
git clone https://github.com/Praktek-CC-UB-2026/Backend.git
git clone https://github.com/Praktek-CC-UB-2026/Frontend.git

# 2. Checkout branch complete
cd Backend
git checkout complete

cd ../Frontend
git checkout complete

# 3. Kembali ke Backend, jalankan semua service
cd ../Backend
docker-compose up -d --build

# 4. Jalankan migration & seeder
docker-compose exec backend php artisan migrate --seed

# 5. Akses aplikasi
# Frontend: http://localhost:8080
# Backend API: http://localhost:8000/api
# Grafana: http://localhost:3001 (admin/admin)
```

## Development Mode (Tanpa Docker)

### Backend

```bash
# Install dependencies
composer install

# Setup environment
cp .env.example .env
php artisan key:generate

# Konfigurasi database di file .env

# Jalankan migration & seeder
php artisan migrate --seed

# Jalankan server
php artisan serve
```

### Frontend

```bash
cd ../Frontend
npm install
npm run dev
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

## Docker Files

| File | Keterangan |
|------|-----------|
| `Dockerfile` | PHP 8.3 FPM Alpine image |
| `docker-compose.yml` | Orchestrate semua service |
| `.dockerignore` | Exclude vendor, .env, cache |
| `.env.docker` | Environment untuk Docker |
| `docker/nginx/default.conf` | Nginx reverse proxy config |
| `docker/prometheus/prometheus.yml` | Prometheus scrape config |
| `docker/grafana/provisioning/` | Grafana auto-provisioning |
| `docker/grafana/dashboards/` | Pre-built monitoring dashboard |

## Monitoring

### Grafana Dashboard

1. Buka http://localhost:3001
2. Login dengan `admin` / `admin`
3. Dashboard "Container Monitoring - Task Manager" sudah ter-provisioning otomatis

### Metrics yang Dipantau

- **CPU Usage**: Penggunaan CPU per container
- **Memory Usage**: Penggunaan RAM per container
- **Network I/O**: Traffic jaringan masuk/keluar per container

### PromQL Queries

```promql
# CPU usage per container
rate(container_cpu_usage_seconds_total{name=~"task_.*"}[1m]) * 100

# Memory usage per container
container_memory_usage_bytes{name=~"task_.*"}

# Network receive rate
rate(container_network_receive_bytes_total{name=~"task_.*"}[1m])
```

## Troubleshooting

### Backend tidak bisa connect ke MySQL

```bash
docker-compose ps
docker-compose logs mysql
docker-compose exec backend php artisan migrate --seed
```

### Frontend tidak bisa akses API

1. Pastikan backend berjalan di port 8000
2. Cek CORS configuration di `config/cors.php`
3. Pastikan token tersimpan di localStorage

### Grafana tidak menampilkan data

1. Pastikan cAdvisor berjalan: http://localhost:8081
2. Cek Prometheus targets: http://localhost:9090/targets
3. Tunggu 1-2 menit untuk data terkumpul
