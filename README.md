# 🌾 FarmEquip

**Platform Rental Alat Pertanian Modern**

[![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![Go](https://img.shields.io/badge/Go-1.25-00ADD8?style=for-the-badge&logo=go&logoColor=white)](https://golang.org)
[![MySQL](https://img.shields.io/badge/MySQL-8.4-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://www.mysql.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4.1-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)

---

## 📖 Deskripsi Proyek

**FarmEquip** adalah platform web full-stack untuk rental alat-alat pertanian modern. Proyek ini menggabungkan **Laravel (PHP)** sebagai frontend dan **Go (Golang)** sebagai REST API backend, dengan database MySQL dan penyimpanan gambar di Cloudinary.

Platform ini memungkinkan petani untuk menyewa berbagai alat pertanian seperti traktor, combine harvester, drone sprayer, dan lainnya dengan harga harian, mingguan, atau bulanan.

---

## 🚀 Tech Stack

### Backend (Go API)
- **Framework:** Gorilla Mux untuk routing
- **Database:** MySQL dengan driver `go-sql-driver/mysql`
- **Cloud Storage:** Cloudinary untuk upload gambar
- **Architecture:** RESTful API dengan functional programming approach

### Frontend (Laravel)
- **Framework:** Laravel 11
- **Template Engine:** Blade
- **Styling:** Tailwind CSS + Flowbite Components
- **HTTP Client:** Guzzle untuk consume Go API

---

## ✨ Fitur Utama

- 🔐 **Authentication** - Sistem login admin dengan session management
- 🛠️ **CRUD Alat** - Manage alat pertanian dengan validasi lengkap
- 📂 **Kategori** - Organisasi alat berdasarkan kategori dinamis
- 🔍 **Search & Filter** - Pencarian dan filter berdasarkan nama & kategori
- 📊 **Sorting** - Sort by nama atau harga (ascending/descending)
- ☁️ **Cloud Upload** - Upload gambar ke Cloudinary
- 📱 **Responsive Design** - Tampilan optimal di semua perangkat
- 🎨 **Modern UI** - Interface yang clean dengan Tailwind CSS

---

## 📁 Struktur Proyek

```
farmequip/
├── app/                      # Laravel Backend
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminAuthController.php
│   │   │   ├── ToolController.php
│   │   │   └── ToolAdminController.php
│   │   └── Middleware/
│   │       └── RoleMiddleware.php
│   └── Models/
│       ├── Tool.php
│       └── User.php
├── resources/
│   └── views/
│       ├── admin/
│       │   ├── login.blade.php
│       │   └── manage/
│       ├── home.blade.php
│       ├── catalog.blade.php
│       └── product.blade.php
├── routes/
│   └── web.php
└── farmequip_api/            # Go Backend API
    ├── database/
    │   ├── db.go
    │   └── cloudinary.go
    ├── handlers/
    │   ├── alat.go
    │   ├── kategori.go
    │   └── users.go
    ├── models/
    │   ├── alat.go
    │   ├── kategori.go
    │   └── users.go
    ├── utils/
    │   └── slug.go
    ├── routes.go
    └── main.go
```

---

## 🔧 Instalasi & Setup

### Prerequisites

- PHP 8.2+
- Composer
- Go 1.22+
- MySQL 8.0+
- Node.js & npm

### 1. Clone Repository

```bash
git clone https://github.com/username/farmequip.git
cd farmequip
```

### 2. Setup Laravel (Frontend)

```bash
# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Configure database in .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=farmequip
DB_USERNAME=your_username
DB_PASSWORD=your_password

# Run migrations
php artisan migrate

# Build assets
npm run build

# Start server
php artisan serve
```

### 3. Setup Go API (Backend)

```bash
cd farmequip_api

# Install dependencies
go mod download

# Create .env file
cat > .env << EOF
DB_USER=your_db_user
DB_PASS=your_db_password
DB_HOST=localhost
DB_PORT=3306
DB_NAME=farmequip
CLOUD_NAME=your_cloudinary_name
CLOUD_KEY=your_cloudinary_key
CLOUD_SECRET=your_cloudinary_secret
PORT=8080
EOF

# Run API server
go run main.go routes.go
```

> ℹ️ **Info:** API akan berjalan di `http://localhost:8080` dan Laravel di `http://localhost:8000`

---

## 🗄️ Database Schema

### Tabel: `alat_pertanian`

| Column | Type | Description |
|--------|------|-------------|
| id | INT | Primary Key |
| nama_alat | VARCHAR(255) | Nama alat pertanian |
| kategori_id | INT | Foreign Key ke tabel kategori |
| deskripsi | TEXT | Deskripsi detail alat |
| spesifikasi | TEXT | Spesifikasi teknis |
| harga_per_hari | INT | Harga rental harian |
| harga_per_minggu | INT | Harga rental mingguan |
| harga_per_bulan | INT | Harga rental bulanan |
| gambar | VARCHAR(255) | URL Cloudinary |

### Tabel: `kategori`

| Column | Type | Description |
|--------|------|-------------|
| id | INT | Primary Key |
| nama_kategori | VARCHAR(255) | Nama kategori |
| slug | VARCHAR(255) | URL-friendly slug |
| deskripsi | TEXT | Deskripsi kategori |

### Tabel: `users`

| Column | Type | Description |
|--------|------|-------------|
| id | INT | Primary Key |
| nama | VARCHAR(255) | Nama lengkap |
| email | VARCHAR(255) | Email address |
| username | VARCHAR(255) | Username untuk login |
| password | VARCHAR(255) | Hashed password |

---

## 🔌 API Endpoints

### Authentication

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/login` | Login user |

**Request Body:**
```json
{
  "username": "admin",
  "password": "admin"
}
```

### Kategori

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/kategori` | Get all categories |
| POST | `/kategori` | Create new category |
| PUT | `/kategori?id={id}` | Update category |
| DELETE | `/kategori?id={id}` | Delete category |

**Create/Update Body:**
```json
{
  "nama_kategori": "Mesin Berat",
  "deskripsi": "Alat pertanian mesin berat"
}
```

### Alat

| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/alat` | Get all tools (with optional sort param) |
| GET | `/alat/{id}` | Get tool by ID |
| GET | `/alat/{slug}` | Get tools by category slug |
| POST | `/alat` | Create new tool (multipart/form-data) |
| PUT | `/alat?id={id}` | Update tool (multipart/form-data) |
| DELETE | `/alat?id={id}` | Delete tool |

**Create/Update (Multipart Form Data):**
```
nama_alat: Traktor Modern
kategori_id: 1
deskripsi: Traktor untuk mengolah lahan
spesifikasi: Mesin diesel 100 HP
harga_per_hari: 500000
harga_per_minggu: 3000000
harga_per_bulan: 10000000
gambar: [file]
```

**Query Parameters untuk GET /alat:**
- `sort=nama_asc` - Sort by nama A-Z
- `sort=nama_desc` - Sort by nama Z-A
- `sort=harga_asc` - Sort by harga terendah
- `sort=harga_desc` - Sort by harga tertinggi

---

## 🎨 Fitur Frontend

### User Pages

- **Home:** Landing page dengan hero section, statistik, dan kategori populer
- **Catalog:** Halaman daftar alat dengan search, filter, dan sorting
- **Product Detail:** Informasi lengkap alat dengan accordion untuk spesifikasi

### Admin Pages

- **Login:** Autentikasi admin dengan animated wave background
- **Dashboard:** Overview statistik dan management tools
- **Manage Tools:** CRUD interface untuk alat pertanian
- **Categories:** Management kategori dalam modal

> ⚠️ **Warning:** Saat menghapus kategori, semua alat dalam kategori tersebut akan dipindahkan ke kategori "Uncategorized"

---

## 🔐 Authentication Flow

1. User mengakses `/admin/login`
2. Submit username & password ke Laravel controller
3. Laravel mengirim request ke Go API `/login`
4. Go API validasi kredensial di database
5. Jika valid, Laravel menyimpan session dan redirect ke dashboard
6. Middleware `RoleMiddleware` melindungi route admin

---
<div align="center">

**FarmEquip** - Solusi Tani Modern

Built with ❤️ using Laravel & Go

© 2025 FarmEquip. All rights reserved.

</div>
