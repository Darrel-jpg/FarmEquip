# Tool Alat Pertanian

API untuk manajemen penyewaan alat dengan pendekatan functional programming menggunakan Go.

## 📋 Daftar Isi
- [Fitur](#fitur)
- [Instalasi](#instalasi)
- [Endpoint API](#endpoint-api)
- [Contoh Penggunaan](#contoh-penggunaan)
- [Error Handling](#error-handling)

## ✨ Fitur

- CRUD operations untuk manajemen alat
- Functional programming approach (Map, Filter, Reduce)
- Higher-order functions dan closures
- Immutable data structures
- Concurrent data processing dengan goroutines
- Custom error handling
- Logging middleware
- Health check endpoint


## 📦 Instalasi

cara mengaktifkan route api
1. Clone repo
2. run farmequipment.sql di database mysql
3. go run main.go

cara menggunakan laravel
1. clone repo
2. composer install
3. npm run build
4. php artisan key:generate

## 📡 Endpoint API

### 1. Health Check
Memeriksa status kesehatan aplikasi dan koneksi database.

**Endpoint:** `GET http://localhost:8080/health`

**Response:**
```json
{
  "status": "healthy",
  "database": "connected"
}
```

---

### 2. Get All Tools
Mengambil semua alat yang tersedia dengan filtering, transformasi, dan agregasi.

**Endpoint:** `GET http://localhost:8080/tools`

**Response:**
```json
{
  "tools": [
    {
      "id": 1,
      "name": "Alat: Bor Listrik",
      "category": "Elektronik",
      "price_per_day": 50000,
      "status": "tersedia",
      "description": "Bor listrik 500W",
      "image_url": "https://example.com/bor.jpg"
    }
  ],
  "total_count": 1,
  "total_price": 50000
}
```

**Catatan:** 
- Response hanya menampilkan alat dengan status "tersedia"
- Nama alat otomatis ditambahkan prefix "Alat:"
- Total price adalah agregasi dari semua harga alat tersedia

---

### 3. Get Tool by ID
Mengambil detail alat berdasarkan ID.

**Endpoint:** `GET http://localhost:8080/tools/{id}`

**Parameter:**
- `id` (path parameter): ID alat

**Response Success:**
```json
{
  "id": 1,
  "name": "Bor Listrik",
  "category": "Elektronik",
  "price_per_day": 50000,
  "status": "tersedia",
  "description": "Bor listrik 500W",
  "image_url": "https://example.com/bor.jpg"
}
```

**Response Error (404):**
```json
{
  "code": 404,
  "message": "Tool not found"
}
```

---

### 4. Create Tool
Membuat alat baru.

**Endpoint:** `POST http://localhost:8080/tools`

**Request Body:**
```json
{
  "name": "Bor Listrik",
  "category": "Elektronik",
  "price_per_day": 50000,
  "status": "tersedia",
  "description": "Bor listrik 500W",
  "image_url": "https://example.com/bor.jpg"
}
```

**Field Requirements:**
- `name` (required): Nama alat
- `category` (required): Kategori alat
- `price_per_day` (required): Harga sewa per hari (harus > 0)
- `status` (optional): Status alat (default: "tersedia")
- `description` (optional): Deskripsi alat
- `image_url` (optional): URL gambar alat

**Response Success (201):**
```json
{
  "id": 1,
  "name": "Bor Listrik",
  "category": "Elektronik",
  "price_per_day": 50000,
  "status": "tersedia",
  "description": "Bor listrik 500W",
  "image_url": "https://example.com/bor.jpg"
}
```

**Response Error (400):**
```json
{
  "code": 400,
  "message": "Validation errors: [Name is required]"
}
```

---

### 5. Update Tool
Mengupdate data alat (partial update supported).

**Endpoint:** `PUT http://localhost:8080/tools/{id}`

**Parameter:**
- `id` (path parameter): ID alat

**Request Body:**
```json
{
  "name": "Bor Listrik Pro",
  "price_per_day": 60000,
  "status": "dipinjam"
}
```

**Catatan:** 
- Semua field bersifat optional
- Field yang tidak dikirim akan mempertahankan nilai lama
- Minimal satu field harus diisi

**Response Success:**
```json
{
  "id": 1,
  "name": "Bor Listrik Pro",
  "category": "Elektronik",
  "price_per_day": 60000,
  "status": "dipinjam",
  "description": "Bor listrik 500W",
  "image_url": "https://example.com/bor.jpg"
}
```

**Response Error (404):**
```json
{
  "code": 404,
  "message": "Tool not found"
}
```

---

### 6. Delete Tool
Menghapus alat berdasarkan ID.

**Endpoint:** `DELETE http://localhost:8080/tools/{id}`

**Parameter:**
- `id` (path parameter): ID alat

**Response Success:**
```json
{
  "message": "Tool deleted successfully",
  "id": 1,
  "empty_result": []
}
```

**Response Error (404):**
```json
{
  "code": 404,
  "message": "Tool not found"
}
```

## 💡 Contoh Penggunaan

### Menggunakan cURL

#### 1. Health Check
```bash
curl http://localhost:8080/health
```

#### 2. Get All Tools
```bash
curl http://localhost:8080/tools
```

#### 3. Get Tool by ID
```bash
curl http://localhost:8080/tools/1
```

#### 4. Create Tool
```bash
curl -X POST http://localhost:8080/tools \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Bor Listrik",
    "category": "Elektronik",
    "price_per_day": 50000,
    "description": "Bor listrik 500W",
    "image_url": "https://example.com/bor.jpg"
  }'
```

#### 5. Update Tool
```bash
curl -X PUT http://localhost:8080/tools/1 \
  -H "Content-Type: application/json" \
  -d '{
    "name": "Bor Listrik Pro",
    "price_per_day": 60000,
    "status": "dipinjam"
  }'
```

#### 6. Delete Tool
```bash
curl -X DELETE http://localhost:8080/tools/1
```

### Menggunakan JavaScript (Fetch API)

```javascript
// Get All Tools
fetch('http://localhost:8080/tools')
  .then(response => response.json())
  .then(data => console.log(data));

// Create Tool
fetch('http://localhost:8080/tools', {
  method: 'POST',
  headers: {
    'Content-Type': 'application/json',
  },
  body: JSON.stringify({
    name: 'Bor Listrik',
    category: 'Elektronik',
    price_per_day: 50000,
    description: 'Bor listrik 500W'
  })
})
  .then(response => response.json())
  .then(data => console.log(data));

// Update Tool
fetch('http://localhost:8080/tools/1', {
  method: 'PUT',
  headers: {
    'Content-Type': 'application/json',
  },
  body: JSON.stringify({
    price_per_day: 60000,
    status: 'dipinjam'
  })
})
  .then(response => response.json())
  .then(data => console.log(data));

// Delete Tool
fetch('http://localhost:8080/tools/1', {
  method: 'DELETE'
})
  .then(response => response.json())
  .then(data => console.log(data));
```

## ⚠️ Error Handling

API menggunakan custom error handling dengan format standar:

```json
{
  "code": 400,
  "message": "Error message description"
}
```

### HTTP Status Codes

| Status Code | Deskripsi |
|-------------|-----------|
| 200 | OK - Request berhasil |
| 201 | Created - Resource berhasil dibuat |
| 400 | Bad Request - Input tidak valid |
| 404 | Not Found - Resource tidak ditemukan |
| 500 | Internal Server Error - Server error |

### Common Errors

**Invalid JSON:**
```json
{
  "code": 400,
  "message": "Invalid JSON"
}
```

**Validation Error:**
```json
{
  "code": 400,
  "message": "Validation errors: [Name is required, Price must be positive]"
}
```

**Tool Not Found:**
```json
{
  "code": 404,
  "message": "Tool not found"
}
```

**Database Error:**
```json
{
  "code": 500,
  "message": "Failed to fetch tools"
}
```
