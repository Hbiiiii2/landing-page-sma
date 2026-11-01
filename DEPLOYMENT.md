# Panduan Deploy Docker ke Internet - SMA Islam Al-Madinah BSD

Panduan ini menjelaskan langkah demi langkah untuk mendeploy website **SMA Islam Al-Madinah BSD** ke server VPS (Virtual Private Server) di internet (misal: DigitalOcean, Linode, AWS Lightsail, Contabo, IdCloudHost, Biznet, dll) menggunakan **Docker & Docker Compose**.

---

## 1. Arsitektur Layanan Docker

| Layanan | Komponen | Deskripsi |
|---|---|---|
| `web` | **Nginx (Alpine)** | Web server statis, reverse proxy FastCGI ke PHP-FPM, Gzip, caching asset, proteksi security headers, dan batas upload 50MB. |
| `app` | **PHP 8.4-FPM + Laravel 12 + Filament** | Backend aplikasi, auto-wait database, auto-migrasi skema, auto-cache konfigurasi production, dan storage linking. |
| `db` | **MySQL 8.0** | Database utama dengan volume persisten `db_data` (data aman tidak akan hilang saat container restart). |
| `queue` | **Queue Worker** | Worker background processing untuk email & antrean tugas asynchronous. |
| `scheduler`| **Cron Scheduler** | Eksekutor cron jobs otomatis Laravel (`schedule:work`). |

---

## 2. Persiapan Server VPS

Pastikan Anda memiliki VPS berbasis Linux (direkomendasikan: **Ubuntu 22.04 LTS** atau **Ubuntu 24.04 LTS**).

### A. Update Server & Install Docker
Jalankan di terminal VPS Anda:

```bash
# 1. Update paket sistem
sudo apt update && sudo apt upgrade -y

# 2. Install dependensi umum & Git
sudo apt install -y curl git ufw

# 3. Install Docker Engine & Docker Compose Plugin
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh

# 4. Berikan izin non-root untuk user (opsional)
sudo usermod -aG docker $USER
newgrp docker

# 5. Verifikasi instalasi
docker --version
docker compose version
```

### B. Konfigurasi Firewall VPS
Buka port HTTP (80) dan HTTPS (443):

```bash
sudo ufw allow 22/tcp
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw enable
```

---

## 3. Langkah Deploy Aplikasi

### Langkah 1: Clone Repositori ke Server VPS
Masuk ke direktori web server (misal `/var/www/`):

```bash
sudo mkdir -p /var/www
cd /var/www
git clone https://github.com/Hbiiiii2/landing-page-sma.git smaalmadinah
cd smaalmadinah
```

### Langkah 2: Buat & Sesuaikan File `.env`
Salin template konfigurasi Docker:

```bash
cp .env.docker.example .env
nano .env
```

Sesuaikan parameter penting berikut:
- `APP_NAME`: `"SMA Islam Al-Madinah BSD"`
- `APP_ENV`: `production`
- `APP_DEBUG`: `false`
- `APP_URL`: Masukkan domain Anda, contoh: `https://smaalmadinah.sch.id`
- `APP_PORT`: `8020` *(Bebas bentrok dengan SMP yang menggunakan port 8010)*
- `DB_DATABASE`: `sma`
- `DB_USERNAME`: `sma_user`
- `DB_PASSWORD`: Buat password database yang kuat
- `DB_ROOT_PASSWORD`: Buat password root database yang kuat
- Konfigurasi email SMTP jika ingin mengirim notifikasi (opsional).

Simpan dengan menekan `CTRL + O`, lalu `Enter`, dan keluar dengan `CTRL + X`.

### Langkah 3: Build & Jalankan Container
Jalankan perintah berikut:

```bash
docker compose up -d --build
```

Docker akan secara otomatis:
1. Membuild aset frontend (Tailwind & Vite) via Node 22.
2. Menginstall dependensi Composer production PHP 8.4.
3. Menyalakan MySQL 8.0 dan menunggu hingga database siap menerima koneksi.
4. Menjalankan migrasi database (`php artisan migrate --force`).
5. Menghubungkan symlink penyimpanan (`php artisan storage:link`).
6. Melakukan optimasi caching (`config:cache`, `route:cache`, `view:cache`).

### Langkah 4: Generate Application Key
Jika `APP_KEY` pada file `.env` masih kosong, jalankan:

```bash
docker compose exec sma-almadinah-app php artisan key:generate --force
docker compose exec sma-almadinah-app php artisan config:cache
```

### Langkah 5: Buat Akun Admin Filament
Untuk login ke dashboard admin Filament (`/admin`):

```bash
# Opsi 1: Jalankan Seeder awal (jika sudah ada seeder default)
docker compose exec sma-almadinah-app php artisan db:seed --force

# Opsi 2: Atau buat user admin baru secara interaktif
docker compose exec sma-almadinah-app php artisan make:filament-user
```
Masukkan nama, email, dan password admin Anda.

---

## 4. Konfigurasi Domain & Cloudflare (HTTPS di Internet)

Karena server VPS Anda sudah memiliki container **Cloudflare Tunnel** yang aktif di dalam **`smart-network`**, Anda **TIDAK PERLU** membuat container tunnel baru ataupun memasukkan token tunnel baru di project ini.

Cukup hubungkan domain SMA melalui dashboard Cloudflare:

1. Buka dashboard [Cloudflare Zero Trust](https://one.dash.cloudflare.com/).
2. Buka menu **Networks** &rarr; **Tunnels**.
3. Pilih Tunnel Anda yang sedang aktif &rarr; klik **Configure**.
4. Buka tab **Public Hostname** &rarr; klik **Add a public hostname**.
5. Isi konfigurasi:
   - **Subdomain / Domain**: Masukkan domain yang Anda inginkan (misal `smaalmadinah.sch.id` atau `sma.domainanda.com`).
   - **Service Type**: `HTTP`
   - **URL**: `sma-almadinah-web:80` *(langsung terhubung melalui DNS container di dalam `smart-network`)*
     *(Atau gunakan `localhost:8020` jika diarahkan via host)*
6. Klik **Save Hostname**.
7. Website SMA langsung aktif di internet dengan sertifikat SSL/HTTPS otomatis dari Cloudflare tanpa perlu buka port firewall tambahan!

---

### Opsi Alternatif: Direct IP VPS (Tanpa Tunnel)
Jika suatu saat Anda ingin mengakses langsung via IP VPS tanpa Cloudflare Tunnel:
1. Di DNS Cloudflare, buat **A Record** mengarah ke IP Public VPS (Proxy status: ON / Awan Oranye).
2. Di `.env`, ubah `APP_PORT=80` (pastikan port 80 VPS belum dipakai aplikasi lain).
3. Jalankan `docker compose up -d`.

---

## 5. Perintah Manajemen Operasional

### Melihat Status & Log Container
```bash
# Cek semua container yang sedang berjalan
docker compose ps

# Cek log aplikasi Laravel secara live
docker compose logs -f sma-almadinah-app

# Cek log web server Nginx secara live
docker compose logs -f sma-almadinah-web

# Cek log database
docker compose logs -f sma-almadinah-db
```

### Update Aplikasi / Redeploy Versi Terbaru
Ketika Anda melakukan update kode atau commit baru:

```bash
cd /var/www/smaalmadinah
git pull origin main
docker compose up -d --build
```
*Catatan: Data di database MySQL dan file upload foto/brosur di storage tidak akan terhapus karena disimpan di Docker Volumes persisten (`sma-almadinah-db-data` dan `sma-almadinah-app-storage`).*

### Backup & Restore Database
```bash
# Backup database ke file .sql
docker compose exec sma-almadinah-db mysqldump -u sma_user -pGantiPasswordKuatDB123! sma > backup_sma_$(date +%F).sql

# Restore database dari file .sql
docker compose exec -T sma-almadinah-db mysql -u sma_user -pGantiPasswordKuatDB123! sma < backup_sma_2026-10-08.sql
```

### Membersihkan / Refresh Cache Aplikasi
```bash
docker compose exec sma-almadinah-app php artisan optimize:clear
docker compose exec sma-almadinah-app php artisan optimize
```
