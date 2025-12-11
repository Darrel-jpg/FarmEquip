<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FarmEquip - README</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #73AF6F 0%, #5e9c5a 100%);
            color: white;
            padding: 40px;
            text-align: center;
        }
        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        }
        .header p {
            font-size: 1.2em;
            opacity: 0.95;
        }
        .content {
            padding: 40px;
        }
        h2 {
            color: #73AF6F;
            margin-top: 30px;
            margin-bottom: 15px;
            font-size: 1.8em;
            border-bottom: 3px solid #73AF6F;
            padding-bottom: 10px;
        }
        h3 {
            color: #5e9c5a;
            margin-top: 20px;
            margin-bottom: 10px;
            font-size: 1.4em;
        }
        p, li {
            margin-bottom: 10px;
            font-size: 1.05em;
        }
        ul, ol {
            margin-left: 30px;
            margin-bottom: 20px;
        }
        code {
            background: #f4f4f4;
            padding: 2px 8px;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
            color: #e83e8c;
        }
        pre {
            background: #2d2d2d;
            color: #f8f8f2;
            padding: 20px;
            border-radius: 8px;
            overflow-x: auto;
            margin: 20px 0;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        pre code {
            background: none;
            color: inherit;
            padding: 0;
        }
        .badge {
            display: inline-block;
            padding: 5px 12px;
            background: #73AF6F;
            color: white;
            border-radius: 20px;
            font-size: 0.85em;
            margin-right: 8px;
            margin-bottom: 8px;
        }
        .tech-stack {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 20px 0;
        }
        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }
        .feature-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #73AF6F;
        }
        .feature-card h4 {
            color: #73AF6F;
            margin-bottom: 8px;
        }
        .warning {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .info {
            background: #d1ecf1;
            border-left: 4px solid #17a2b8;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .footer {
            background: #f8f9fa;
            padding: 30px 40px;
            text-align: center;
            border-top: 1px solid #dee2e6;
        }
        a {
            color: #73AF6F;
            text-decoration: none;
            font-weight: 600;
        }
        a:hover {
            text-decoration: underline;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background: #73AF6F;
            color: white;
            font-weight: 600;
        }
        tr:hover {
            background: #f5f5f5;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🌾 FarmEquip</h1>
            <p>Platform Rental Alat Pertanian Modern</p>
        </div>

        <div class="content">
            <section>
                <h2>📖 Deskripsi Proyek</h2>
                <p>
                    <strong>FarmEquip</strong> adalah platform web full-stack untuk rental alat-alat pertanian modern. 
                    Proyek ini menggabungkan Laravel (PHP) sebagai frontend dan Go (Golang) sebagai REST API backend, 
                    dengan database MySQL dan penyimpanan gambar di Cloudinary.
                </p>
                <p>
                    Platform ini memungkinkan petani untuk menyewa berbagai alat pertanian seperti traktor, combine harvester, 
                    drone sprayer, dan lainnya dengan harga harian, mingguan, atau bulanan.
                </p>
            </section>

            <section>
                <h2>🚀 Tech Stack</h2>
                <div class="tech-stack">
                    <span class="badge">Laravel 11</span>
                    <span class="badge">Go 1.22</span>
                    <span class="badge">MySQL</span>
                    <span class="badge">Tailwind CSS</span>
                    <span class="badge">Flowbite</span>
                    <span class="badge">Cloudinary</span>
                    <span class="badge">Gorilla Mux</span>
                </div>

                <h3>Backend (Go API)</h3>
                <ul>
                    <li><strong>Framework:</strong> Gorilla Mux untuk routing</li>
                    <li><strong>Database:</strong> MySQL dengan driver go-sql-driver/mysql</li>
                    <li><strong>Cloud Storage:</strong> Cloudinary untuk upload gambar</li>
                    <li><strong>Architecture:</strong> RESTful API dengan functional programming approach</li>
                </ul>

                <h3>Frontend (Laravel)</h3>
                <ul>
                    <li><strong>Framework:</strong> Laravel 11</li>
                    <li><strong>Template Engine:</strong> Blade</li>
                    <li><strong>Styling:</strong> Tailwind CSS + Flowbite Components</li>
                    <li><strong>HTTP Client:</strong> Guzzle untuk consume Go API</li>
                </ul>
            </section>

            <section>
                <h2>✨ Fitur Utama</h2>
                <div class="feature-grid">
                    <div class="feature-card">
                        <h4>🔐 Authentication</h4>
                        <p>Sistem login admin dengan session management</p>
                    </div>
                    <div class="feature-card">
                        <h4>🛠️ CRUD Alat</h4>
                        <p>Manage alat pertanian dengan validasi lengkap</p>
                    </div>
                    <div class="feature-card">
                        <h4>📂 Kategori</h4>
                        <p>Organisasi alat berdasarkan kategori dinamis</p>
                    </div>
                    <div class="feature-card">
                        <h4>🔍 Search & Filter</h4>
                        <p>Pencarian dan filter berdasarkan nama & kategori</p>
                    </div>
                    <div class="feature-card">
                        <h4>📊 Sorting</h4>
                        <p>Sort by nama atau harga (ascending/descending)</p>
                    </div>
                    <div class="feature-card">
                        <h4>☁️ Cloud Upload</h4>
                        <p>Upload gambar ke Cloudinary</p>
                    </div>
                </div>
            </section>

            <section>
                <h2>📁 Struktur Proyek</h2>
                <pre><code>farmequip/
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
    └── main.go</code></pre>
            </section>

            <section>
                <h2>🔧 Instalasi & Setup</h2>
                
                <h3>Prerequisites</h3>
                <ul>
                    <li>PHP 8.2+</li>
                    <li>Composer</li>
                    <li>Go 1.22+</li>
                    <li>MySQL 8.0+</li>
                    <li>Node.js & npm</li>
                </ul>

                <h3>1. Clone Repository</h3>
                <pre><code>git clone https://github.com/username/farmequip.git
cd farmequip</code></pre>

                <h3>2. Setup Laravel (Frontend)</h3>
                <pre><code># Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate

# Build assets
npm run build

# Start server
php artisan serve</code></pre>

                <h3>3. Setup Go API (Backend)</h3>
                <pre><code>cd farmequip_api

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
go run main.go routes.go</code></pre>

                <div class="info">
                    <strong>ℹ️ Info:</strong> API akan berjalan di <code>http://localhost:8080</code> dan Laravel di <code>http://localhost:8000</code>
                </div>
            </section>

            <section>
                <h2>🗄️ Database Schema</h2>
                <h3>Tabel: alat_pertanian</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Column</th>
                            <th>Type</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>id</td>
                            <td>INT</td>
                            <td>Primary Key</td>
                        </tr>
                        <tr>
                            <td>nama_alat</td>
                            <td>VARCHAR(255)</td>
                            <td>Nama alat pertanian</td>
                        </tr>
                        <tr>
                            <td>kategori_id</td>
                            <td>INT</td>
                            <td>Foreign Key ke tabel kategori</td>
                        </tr>
                        <tr>
                            <td>deskripsi</td>
                            <td>TEXT</td>
                            <td>Deskripsi detail alat</td>
                        </tr>
                        <tr>
                            <td>spesifikasi</td>
                            <td>TEXT</td>
                            <td>Spesifikasi teknis</td>
                        </tr>
                        <tr>
                            <td>harga_per_hari</td>
                            <td>INT</td>
                            <td>Harga rental harian</td>
                        </tr>
                        <tr>
                            <td>harga_per_minggu</td>
                            <td>INT</td>
                            <td>Harga rental mingguan</td>
                        </tr>
                        <tr>
                            <td>harga_per_bulan</td>
                            <td>INT</td>
                            <td>Harga rental bulanan</td>
                        </tr>
                        <tr>
                            <td>gambar</td>
                            <td>VARCHAR(255)</td>
                            <td>URL Cloudinary</td>
                        </tr>
                    </tbody>
                </table>

                <h3>Tabel: kategori</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Column</th>
                            <th>Type</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>id</td>
                            <td>INT</td>
                            <td>Primary Key</td>
                        </tr>
                        <tr>
                            <td>nama_kategori</td>
                            <td>VARCHAR(255)</td>
                            <td>Nama kategori</td>
                        </tr>
                        <tr>
                            <td>slug</td>
                            <td>VARCHAR(255)</td>
                            <td>URL-friendly slug</td>
                        </tr>
                        <tr>
                            <td>deskripsi</td>
                            <td>TEXT</td>
                            <td>Deskripsi kategori</td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <section>
                <h2>🔌 API Endpoints</h2>
                
                <h3>Authentication</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Method</th>
                            <th>Endpoint</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>POST</td>
                            <td>/login</td>
                            <td>Login user</td>
                        </tr>
                    </tbody>
                </table>

                <h3>Kategori</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Method</th>
                            <th>Endpoint</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>GET</td>
                            <td>/kategori</td>
                            <td>Get all categories</td>
                        </tr>
                        <tr>
                            <td>POST</td>
                            <td>/kategori</td>
                            <td>Create new category</td>
                        </tr>
                        <tr>
                            <td>PUT</td>
                            <td>/kategori?id={id}</td>
                            <td>Update category</td>
                        </tr>
                        <tr>
                            <td>DELETE</td>
                            <td>/kategori?id={id}</td>
                            <td>Delete category</td>
                        </tr>
                    </tbody>
                </table>

                <h3>Alat</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Method</th>
                            <th>Endpoint</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>GET</td>
                            <td>/alat</td>
                            <td>Get all tools (with sort param)</td>
                        </tr>
                        <tr>
                            <td>GET</td>
                            <td>/alat/{id}</td>
                            <td>Get tool by ID</td>
                        </tr>
                        <tr>
                            <td>GET</td>
                            <td>/alat/{slug}</td>
                            <td>Get tools by category slug</td>
                        </tr>
                        <tr>
                            <td>POST</td>
                            <td>/alat</td>
                            <td>Create new tool (multipart/form-data)</td>
                        </tr>
                        <tr>
                            <td>PUT</td>
                            <td>/alat?id={id}</td>
                            <td>Update tool (multipart/form-data)</td>
                        </tr>
                        <tr>
                            <td>DELETE</td>
                            <td>/alat?id={id}</td>
                            <td>Delete tool</td>
                        </tr>
                    </tbody>
                </table>
            </section>

            <section>
                <h2>🎨 Fitur Frontend</h2>
                <h3>User Pages</h3>
                <ul>
                    <li><strong>Home:</strong> Landing page dengan hero section, statistik, dan kategori populer</li>
                    <li><strong>Catalog:</strong> Halaman daftar alat dengan search, filter, dan sorting</li>
                    <li><strong>Product Detail:</strong> Informasi lengkap alat dengan accordion untuk spesifikasi</li>
                </ul>

                <h3>Admin Pages</h3>
                <ul>
                    <li><strong>Login:</strong> Autentikasi admin dengan animated wave background</li>
                    <li><strong>Dashboard:</strong> Overview statistik dan management tools</li>
                    <li><strong>Manage Tools:</strong> CRUD interface untuk alat pertanian</li>
                    <li><strong>Categories:</strong> Management kategori dalam modal</li>
                </ul>

                <div class="warning">
                    <strong>⚠️ Warning:</strong> Saat menghapus kategori, semua alat dalam kategori tersebut akan dipindahkan ke kategori "Uncategorized"
                </div>
            </section>

            <section>
                <h2>🔐 Authentication Flow</h2>
                <ol>
                    <li>User mengakses <code>/admin/login</code></li>
                    <li>Submit username & password ke Laravel controller</li>
                    <li>Laravel mengirim request ke Go API <code>/login</code></li>
                    <li>Go API validasi kredensial di database</li>
                    <li>Jika valid, Laravel menyimpan session dan redirect ke dashboard</li>
                    <li>Middleware <code>RoleMiddleware</code> melindungi route admin</li>
                </ol>
            </section>

            <section>
                <h2>📝 Best Practices yang Diterapkan</h2>
                <h3>Go API</h3>
                <ul>
                    <li>Functional programming dengan pure functions</li>
                    <li>Higher-order functions untuk reusability</li>
                    <li>Separation of concerns (handlers, models, database)</li>
                    <li>CORS middleware untuk cross-origin requests</li>
                </ul>

                <h3>Laravel</h3>
                <ul>
                    <li>MVC architecture</li>
                    <li>Form validation dengan Laravel request</li>
                    <li>Blade components untuk reusable UI</li>
                    <li>Session-based authentication</li>
                    <li>Middleware untuk route protection</li>
                </ul>
            </section>

            <section>
                <h2>🚧 Troubleshooting</h2>
                <h3>API tidak bisa diakses</h3>
                <ul>
                    <li>Pastikan Go API berjalan di port 8080</li>
                    <li>Check CORS configuration di <code>routes.go</code></li>
                    <li>Verifikasi database connection</li>
                </ul>

                <h3>Upload gambar gagal</h3>
                <ul>
                    <li>Pastikan kredensial Cloudinary sudah benar di <code>.env</code></li>
                    <li>Check file size dan format (max 2MB, JPG/PNG/JPEG)</li>
                </ul>

                <h3>Session tidak tersimpan</h3>
                <ul>
                    <li>Jalankan <code>php artisan config:cache</code></li>
                    <li>Pastikan session driver di <code>.env</code> sudah correct</li>
                </ul>
            </section>

            <section>
                <h2>🔮 Future Improvements</h2>
                <ul>
                    <li>Implementasi sistem booking real-time</li>
                    <li>Payment gateway integration</li>
                    <li>Rating & review system</li>
                    <li>Real-time chat dengan pemilik alat</li>
                    <li>Mobile app (React Native)</li>
                    <li>Advanced analytics dashboard</li>
                    <li>Multi-language support</li>
                </ul>
            </section>

            <section>
                <h2>👨‍💻 Developer</h2>
                <p>Dikembangkan oleh <strong>Your Name</strong></p>
                <p>
                    📧 Email: <a href="mailto:your.email@example.com">your.email@example.com</a><br>
                    🌐 GitHub: <a href="https://github.com/yourusername" target="_blank">@yourusername</a>
                </p>
            </section>

            <section>
                <h2>📄 License</h2>
                <p>This project is licensed under the MIT License - see the LICENSE file for details.</p>
            </section>
        </div>

        <div class="footer">
            <p><strong>FarmEquip</strong> - Solusi Tani Modern</p>
            <p>Built with ❤️ using Laravel & Go</p>
            <p style="margin-top: 10px; color: #666;">© 2025 FarmEquip. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
