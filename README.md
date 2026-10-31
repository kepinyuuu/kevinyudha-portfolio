# Personal Portfolio — Kevin Yudha Pratama

Personal portfolio website profesional untuk **Kevin Yudha Pratama** (UI/UX Designer & Developer) yang dibangun dengan estetika desain modern, minimalis, dan berperforma tinggi menggunakan Laravel 13, Tailwind CSS, dan Alpine.js.

---

## 🎨 Fitur Utama

- **Public Portfolio**:
  - Hero section dinamis dengan tipografi *Playfair Display* & *Inter*.
  - About section informatif (Bio, Edukasi, Interests, Status Pengalaman).
  - Visual skills display dengan kategori (General, Design, Tools) dan level bar interaktif.
  - Featured projects showcase dengan tautan demo dan repository.
  - Interactive Design Gallery dengan filtering kategori (UI/UX, Mobile App, Web Design, dll).
  - Formulir kontak anti-spam (Honeypot protection & Rate Limiting).
  - Responsif penuh untuk Mobile, Tablet, dan Desktop.

- **Admin Management Dashboard**:
  - Autentikasi aman (`/admin/login`) khusus akun admin.
  - Ringkasan statistik (total projects, skills, karya desain, pesan masuk).
  - CRUD Projects (tambah, edit, hapus, unggah thumbnail).
  - CRUD Skills (kelola nama, kategori, level persentase, urutan).
  - CRUD Design Works (unggah screenshot karya, kategori, deskripsi).
  - Inbox Pesan Kontak (baca detail pesan, toggle status read/unread, direct mailto reply, hapus pesan).

---

## 🛠️ Tech Stack

- **Backend**: Laravel 13 (PHP 8.4+ / 8.5)
- **Frontend**: Blade Components, Tailwind CSS, Alpine.js, Vite
- **Database**: SQLite (Local Dev & Testing), MySQL / PostgreSQL (Production)
- **Deployment**: Vercel (Container FrankenPHP via Docker)

---

## 💻 Menjalankan Secara Lokal

1. **Clone repository & Install dependencies**:
   ```bash
   composer install
   npm install
   ```

2. **Setup Environment**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Migrasi Database & Seed Data Awal**:
   ```bash
   php artisan migrate:fresh --seed
   ```
   *Admin default login: `admin@kevinportfolio.com` / `Admin@12345`*

4. **Build Frontend**:
   ```bash
   npm run build
   # atau untuk mode development:
   # npm run dev
   ```

5. **Jalankan Server**:
   ```bash
   php artisan serve
   ```
   Akses aplikasi di `http://localhost:8000`.

6. **Menjalankan Test Suite**:
   ```bash
   php vendor/phpunit/phpunit/phpunit
   ```

---

## 🚀 Panduan Deployment ke Vercel (FrankenPHP Container)

Proyek ini telah dikonfigurasi penuh dengan dukungan container native **FrankenPHP** di Vercel melalui file `Dockerfile`, `Caddyfile`, `vercel.json`, dan `docker/entrypoint.sh`.

### 1. Prasyarat
- Akun [Vercel](https://vercel.com).
- Database online eksternal (misalnya: Supabase PostgreSQL, PlanetScale MySQL, Neon, TiDB Cloud, atau AWS RDS).
- Vercel CLI (`npm i -g vercel`) atau repository terhubung ke GitHub.

### 2. File Konfigurasi Vercel
- **`Dockerfile`**: Multi-stage build (Node 20 untuk Vite compile + `dunglas/frankenphp` untuk web server & PHP worker).
- **`Caddyfile`**: Konfigurasi Caddy/FrankenPHP dengan dukungan port dynamic `:{$PORT:80}` dan serving ke `/app/public`.
- **`vercel.json`**: Menghubungkan build container Docker `@vercel/docker`.
- **`docker/entrypoint.sh`**: Mempersiapkan direktori writable di `/tmp/storage` (karena filesystem Vercel read-only di luar `/tmp`) dan caching route/config otomatis.

### 3. Setup Environment Variables di Vercel Dashboard
Buka **Project Settings > Environment Variables** di Vercel, lalu tambahkan variabel berikut:

| Key | Value Contoh | Keterangan |
|---|---|---|
| `APP_NAME` | `Kevin Yudha Pratama Portfolio` | Nama aplikasi |
| `APP_ENV` | `production` | Environment mode |
| `APP_KEY` | *(Generate via `php artisan key:generate --show`)* | Encryption key |
| `APP_DEBUG` | `false` | Nonaktifkan debug untuk keamanan |
| `APP_URL` | `https://your-portfolio.vercel.app` | URL domain Vercel Anda |
| `APP_STORAGE_PATH` | `/tmp/storage` | Folder writable di container Vercel |
| `VIEW_COMPILED_PATH`| `/tmp/storage/framework/views` | Compiled views cache path |
| `LOG_CHANNEL` | `stderr` | Menampilkan log langsung di Vercel runtime logs |
| `SESSION_DRIVER` | `cookie` | Stateful cookie tanpa ketergantungan storage lokal |
| `CACHE_STORE` | `file` | Cache driver |
| `DB_CONNECTION` | `mysql` *(atau `pgsql`)* | Driver database Anda |
| `DB_HOST` | `aws.connect.psdb.cloud` | Host server DB |
| `DB_PORT` | `3306` *(atau `5432`)* | Port DB |
| `DB_DATABASE` | `kevin_portfolio` | Nama database |
| `DB_USERNAME` | `your_user` | Username DB |
| `DB_PASSWORD` | `your_secret_password` | Password DB |
| `ADMIN_EMAIL` | `admin@kevinportfolio.com` | Email login admin |
| `ADMIN_PASSWORD`| `YourSecurePassword!` | Password login admin |

*(Template lengkap dapat dilihat pada [`.env.vercel.example`](.env.vercel.example))*

### 4. Deploy ke Vercel

#### Opsi A: Menggunakan Vercel CLI
```bash
# Login ke akun Vercel
vercel login

# Deploy ke production
vercel --prod
```

#### Opsi B: Menggunakan GitHub Integration
1. Push branch `main` ke repository GitHub Anda.
2. Buka dashboard Vercel -> **Add New Project** -> Import repository GitHub.
3. Masukkan Environment Variables di atas.
4. Klik **Deploy**. Vercel akan otomatis mengeksekusi `Dockerfile` dan menjalankan container FrankenPHP.

---

## 📋 Laporan Data & Placeholder Netral

Sesuai aturan utama, data yang belum disediakan oleh pengguna telah diberikan placeholder netral yang jelas atau ditangani dengan aman:

| Bagian | Status Data | Penanganan |
|---|---|---|
| **Edukasi** | Belum ada nama kampus/jurusan spesifik | Ditampilkan format placeholder netral: `Universitas — [Nama Kampus & Jurusan]` |
| **Pengalaman Kerja** | Belum ada | Ditampilkan badge status eksplisit *"Belum ada pengalaman kerja formal / Open to Opportunities & Freelance"* |
| **Tautan Sosial** (GitHub, LinkedIn, Instagram) | Belum ada | Tautan disembunyikan secara kondisional (`@if($profile->github_url)`) agar tidak menghasilkan tautan rusak atau dummy |
| **Foto Profil** | Belum ada file foto | Ditampilkan ikon siluet avatar SVG yang selaras dengan tema warna tanpa merusak layout |
| **Proyek & Karya Desain** | Data awal seeder dasar | Disediakan seeder proyek percontohan dan dapat dikelola secara fleksibel kapan saja lewat panel admin |
