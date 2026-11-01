# Personal Portfolio — Kevin Yudha Pratama

Personal portfolio website profesional untuk **Kevin Yudha Pratama** (Web Development & Designer) yang dibangun dengan estetika desain editorial modern, minimalis monokrom (terinspirasi Poulo), dan berperforma tinggi menggunakan Laravel 13, Tailwind CSS, dan Alpine.js.

---

## 🎨 Fitur Utama

- **Public Portfolio**:
  - Hero section editorial dengan tipografi *Manrope* dan identitas Kevin Yudha Pratama (Kevin Yudha P.).
  - About section informatif memuat profil pendidikan SMK Negeri 1 Bangsri jurusan PPLG dan minat.
  - Proyek pilihan interaktif menampilkan perancangan antarmuka website dan proyek Website UMKM Omah Vektor lengkap dengan modal dialog detail dan galeri dokumentasi.
  - Formulir kontak anti-spam (Honeypot protection) terintegrasi dengan variabel lingkungan `MAIL_TO_ADDRESS`.
  - Tampilan dark monochrome elegan berbasis token warna CSS, responsif penuh tanpa overflow di 360/768/1280 px.


- **Admin Management Dashboard**:
  - Autentikasi aman (`/admin/login`) khusus akun admin.
  - Ringkasan statistik (total projects, skills, karya desain, pesan masuk).
  - Edit Profil Lengkap (`/admin/profile`) dengan live preview foto & manajemen tautan sosial.
  - CRUD Projects (tambah, edit, hapus, kelola status publik & unggulan).
  - CRUD Skills (kelola nama, kategori, level persentase, urutan).
  - CRUD Design Works (unggah screenshot karya, kategori, deskripsi).
  - Inbox Pesan Kontak (baca pesan, toggle read/unread, direct mailto reply, hapus pesan).

---

## 🛠️ Tech Stack

- **Backend**: Laravel 13 (PHP 8.4+ / 8.5)
- **Frontend**: Blade Components, Tailwind CSS (v4), Alpine.js, Vite
- **Web Server / Runtime**: FrankenPHP (Caddy engine)
- **Database**: SQLite (Lokal & Vercel mode tanpa DB eksternal), MySQL / PostgreSQL (Opsional untuk production dengan cloud DB)
- **Storage**: Public disk lokal atau S3 / Cloudflare R2 (Opsional)
- **Deployment**: Vercel (Container FrankenPHP via `@vercel/docker`)

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

3. **Konfigurasi Email (Formulir Kontak)**:
   Pesan formulir kontak dikirim langsung melalui email tanpa database. Buka berkas `.env` dan atur parameter email Anda:
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.mailgun.org          # atau host SMTP Anda (misal: smtp.gmail.com)
   MAIL_PORT=587
   MAIL_USERNAME=your_username
   MAIL_PASSWORD=your_password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS="no-reply@yourdomain.com"
   MAIL_FROM_NAME="${APP_NAME}"
   MAIL_TO_ADDRESS=                    # Alamat email tujuan penerima pesan formulir kontak
   ```
   *Catatan*: Jika `MAIL_TO_ADDRESS` tidak diisi, sistem otomatis menggunakan email profil pemilik dari `config/portfolio.php`. Untuk pengujian lokal tanpa kirim email nyata, gunakan `MAIL_MAILER=log`.

4. **Inisialisasi Database & Seeder**:
   Set `ADMIN_NAME`, `ADMIN_EMAIL`, dan `ADMIN_PASSWORD` di berkas `.env` Anda, lalu jalankan:
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Build Frontend**:
   ```bash
   npm run build
   # atau untuk mode development live-reload:
   # npm run dev
   ```

6. **Jalankan Server Lokal**:
   ```bash
   php artisan serve
   ```
   Akses aplikasi di `http://localhost:8000`.

7. **Menjalankan Test Suite**:
   ```bash
   php artisan test
   ```

---

## 🚀 Panduan Deployment ke Vercel (FrankenPHP Container)

Proyek ini telah dikonfigurasi penuh dengan dukungan container native **FrankenPHP** di Vercel melalui file `Dockerfile`, `Caddyfile`, `vercel.json`, dan `docker/entrypoint.sh`.

### Poin Arsitektur Penting:
1. **TrustProxies Aktif**: Dikonfigurasi dengan `trustProxies(at: '*')` di `bootstrap/app.php` sehingga seluruh helper URL dan aset otomatis memakai HTTPS di belakang reverse proxy Vercel.
2. **Logging `stderr`**: `LOG_CHANNEL=stderr` dikonfigurasi agar seluruh log aplikasi mengalir langsung ke tab **Runtime Logs** di Vercel Dashboard.
3. **Tanpa `config:cache` saat build image**: `php artisan config:cache` secara sengaja **TIDAK dijalankan** saat build Docker image. Hal ini krusial agar environment variables yang diinjeksikan oleh Vercel saat runtime dapat dibaca secara dinamis via `env()` / `config()`.
4. **Filesystem Writable di `/tmp`**: Folder penyimpanan sementara diarahkan ke `APP_STORAGE_PATH=/tmp/storage` dan `VIEW_COMPILED_PATH=/tmp/storage/framework/views` karena sistem file kontainer Vercel bersifat *read-only* di luar direktori `/tmp`.

---

### Opsi A: Deploy Tanpa Database Eksternal & Tanpa S3/R2 (Direkomendasikan & Paling Praktis)

Pada mode ini, Anda **tidak memerlukan database cloud berbayar** (MySQL/Supabase) dan **tidak memerlukan S3/R2**. Konten portfolio dibaca langsung dari berkas konfigurasi [`config/portfolio.php`](config/portfolio.php).

#### 1. Isi Data Portofolio di `config/portfolio.php`
Buka file `config/portfolio.php`, lalu ganti tanda `'ISI'` dengan data diri, keahlian, proyek, dan karya Anda:
```php
'profile' => [
    'name'             => 'Kevin Yudha Pratama',
    'title'            => 'UI/UX Designer & Developer',
    'hero_headline'    => "Designing Experiences,\nBuilding the Web.",
    'hero_description' => 'UI/UX Designer & Developer yang memadukan kreativitas visual dengan kemampuan teknis.',
    'email'            => 'kontak@kevinportfolio.com',
    // ...
],
```

#### 2. Konfigurasi Environment Variables di Vercel
Buka **Project Settings > Environment Variables** di Vercel Dashboard, lalu masukkan variabel berikut:

| Key | Value Contoh / Keterangan |
|---|---|
| `APP_NAME` | `Kevin Yudha Pratama Portfolio` |
| `APP_ENV` | `production` |
| `APP_KEY` | *(Salin dari `php artisan key:generate --show`)* |
| `APP_DEBUG` | `false` *(Wajib false untuk keamanan di production)* |
| `APP_URL` | `https://your-portfolio.vercel.app` |
| `APP_STORAGE_PATH` | `/tmp/storage` |
| `VIEW_COMPILED_PATH`| `/tmp/storage/framework/views` |
| `LOG_CHANNEL` | `stderr` |
| `SESSION_DRIVER` | `cookie` *(Stateless, tidak bergantung pada DB)* |
| `CACHE_STORE` | `file` *(Menyimpan cache di /tmp)* |
| `FILESYSTEM_DISK` | `public` *(Tidak memerlukan S3/R2)* |
| `DB_CONNECTION` | `sqlite` |
| `DB_DATABASE` | `/tmp/storage/database.sqlite` |

*(Lihat template lengkap pada [`.env.vercel.example`](.env.vercel.example))*

#### 3. Jalankan Deploy
```bash
vercel --prod
```
Portofolio Anda langsung aktif dan dapat diakses dengan HTTPS penuh di `https://your-portfolio.vercel.app`! Pesan kontak yang dikirim pengunjung akan dicatat dengan rapi ke runtime logs Vercel.

---

### Opsi B: Deploy Penuh dengan Database Eksternal (MySQL/PostgreSQL) & Cloudflare R2 / AWS S3

Gunakan mode ini jika Anda ingin mengaktifkan dashboard admin dinamis untuk CRUD proyek dan unggah file gambar secara langsung dari browser.

#### 1. Prasyarat Cloud:
- **MySQL / PostgreSQL Online**: Layanan seperti PlanetScale, TiDB Cloud, Supabase, Neon, atau AWS RDS.
- **S3-compatible Object Storage**: Cloudflare R2, AWS S3, atau Wasabi.

#### 2. Tambahan Environment Variables di Vercel Dashboard:
Tambahkan / perbarui variabel database dan storage berikut:

| Key | Value Contoh | Keterangan |
|---|---|---|
| `SESSION_DRIVER` | `database` | Session persisten di database |
| `CACHE_STORE` | `database` | Cache persisten di database |
| `DB_CONNECTION` | `mysql` | Driver database (`mysql` atau `pgsql`) |
| `DB_HOST` | `aws.connect.psdb.cloud` | Host server database |
| `DB_PORT` | `3306` | Port server database |
| `DB_DATABASE` | `kevin_portfolio` | Nama database |
| `DB_USERNAME` | `your_user` | Username DB |
| `DB_PASSWORD` | `your_password` | Password DB |
| `FILESYSTEM_DISK` | `s3` | Mengarahkan upload ke cloud bucket |
| `AWS_ACCESS_KEY_ID` | `your_access_key` | Access Key ID |
| `AWS_SECRET_ACCESS_KEY` | `your_secret_key` | Secret Access Key |
| `AWS_DEFAULT_REGION` | `auto` *(atau us-east-1)* | Region storage |
| `AWS_BUCKET` | `portfolio-assets` | Nama bucket |
| `AWS_ENDPOINT` | `https://<account_id>.r2.cloudflarestorage.com` | Endpoint R2 / S3 |
| `AWS_URL` | `https://assets.yourdomain.com` | URL publik untuk menampilkan gambar |
| `ADMIN_NAME` | `Kevin Yudha Pratama` | Nama user admin |
| `ADMIN_EMAIL` | `admin@kevinportfolio.com` | Email login dashboard admin |
| `ADMIN_PASSWORD`| *(Password kuat pilihan Anda)* | Password login admin |

#### 3. Jalankan Migrasi Awal ke Database Cloud
Dari komputer lokal Anda yang terhubung dengan kredensial database cloud di `.env`:
```bash
php artisan migrate --force --seed
```

---

## 📁 Panduan Berkas Konfigurasi `config/portfolio.php`

Berkas [`config/portfolio.php`](config/portfolio.php) adalah pusat pengaturan data portofolio ketika aplikasi berjalan tanpa database atau sebagai data inisialisasi. Seluruh kunci telah disediakan dengan tanda `'ISI'` dan dokumentasi penjelasan:

- **`profile`**: Berisi nama, gelar, headline hero, deskripsi, bio, riwayat pendidikan, minat, pengalaman kerja, foto, dan tautan sosial media (GitHub, LinkedIn, Instagram, dll.). Bagian yang kosong akan disembunyikan secara otomatis pada halaman publik.
- **`skills`**: Daftar array keahlian dengan kategori `'general'` (Development), `'design'` (Desain), atau `'tools'` (Perangkat Kerja), serta level kemahiran 1-100%.
- **`projects`**: Daftar proyek aplikasi/web lengkap dengan deskripsi, teknologi yang dipakai, link demo, dan link GitHub.
- **`navigation`**: Pusat konfigurasi label navigasi (English: `Home`, `About`, `Skills`, `Projects`, `Contact`), tautan anchor (`#home`, `#about`, `#skills`, `#projects`, `#contact`), teks aksi (`View Projects`, `Contact Me`, `Email`), serta teks aksesibilitas (`aria-label`, `title`, skip link, toggle tema).
- **`design_works`**: Galeri visual/desain UI/UX yang mendukung lightbox viewer.
