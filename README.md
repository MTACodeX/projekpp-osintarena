<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# OSINT Arena

OSINT Arena adalah platform CTF lokal khusus OSINT yang dibuat menggunakan Laravel.  
Platform ini bisa dijalankan di localhost, jaringan lokal, atau dikembangkan bersama melalui GitHub.

Project ini cocok untuk latihan, demo kelas, simulasi lomba kecil, dan pembelajaran OSINT CTF.

---

## Fitur Utama

- Landing page
- Register dan login
- Login menggunakan username
- 1 user = 1 team
- Nama team bisa dibuat sendiri atau random
- Challenge khusus OSINT
- Upload file soal dari admin
- Preview gambar langsung di detail challenge
- Submit flag
- Popup benar/salah saat submit flag
- Dynamic scoring
- Scoreboard dengan podium rank 1 sampai 3
- Rank 4 dan seterusnya tampil di tabel
- Scoreboard auto update
- Admin panel
- Bisa diakses lewat localhost atau jaringan lokal

---

## Teknologi yang Digunakan

- PHP
- Laravel
- Blade Template
- SQLite
- CSS custom
- JavaScript
- Git dan GitHub

---

## Requirement

Pastikan perangkat sudah memiliki:

```bash
php
composer
nodejs
npm
git
sqlite
```

Untuk pengguna Arch Linux / WSL:

```bash
sudo pacman -Syu
sudo pacman -S php php-sqlite composer nodejs npm git unzip
```

Cek versi:

```bash
php -v
composer -V
node -v
npm -v
git --version
```

---

## Clone Project

Clone repository:

```bash
git clone https://github.com/USERNAME/projekpp-osintarena.git
cd projekpp-osintarena
```

Ganti `USERNAME` dengan username GitHub pemilik repository.

Contoh:

```bash
git clone https://github.com/MTACodeX/projekpp-osintarena.git
cd projekpp-osintarena
```

---

## Install Dependency

Install dependency Laravel:

```bash
composer install
```

Install dependency frontend:

```bash
npm install
```

---

## Setup Environment

Copy file `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Buka file `.env`:

```bash
nano .env
```

Pastikan konfigurasi penting seperti ini:

```env
APP_NAME="OSINT Arena"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000
APP_TIMEZONE=Asia/Jakarta

DB_CONNECTION=sqlite
```

Setelah menjalankan `php artisan key:generate`, bagian `APP_KEY` akan terisi otomatis.

---

## Setup Database SQLite

Buat file database SQLite:

```bash
touch database/database.sqlite
```

Jalankan migration dan seeder:

```bash
php artisan migrate:fresh --seed
```

Perintah ini akan:

1. Membuat ulang semua tabel database
2. Menjalankan semua migration
3. Mengisi data awal dari seeder
4. Membuat akun admin default

---

## Akun Admin Default

Akun admin dibuat dari file:

```txt
database/seeders/AdminSeeder.php
```

Default login:

```txt
Username : admin
Password : mantaganteng
```

Jika password sudah diganti di `AdminSeeder.php`, gunakan password yang terbaru.

Untuk mengganti password admin default, buka:

```bash
nano database/seeders/AdminSeeder.php
```

Cari:

```php
'password' => Hash::make('mantaganteng'),
```

Ganti menjadi:

```php
'password' => Hash::make('passwordbaru'),
```

Lalu reset database:

```bash
php artisan migrate:fresh --seed
```

---

## Setup Storage untuk Upload File

Agar file upload challenge bisa dibuka dari browser, jalankan:

```bash
php artisan storage:link
```

Jika file upload atau gambar tidak muncul, jalankan ulang:

```bash
rm -rf public/storage
php artisan storage:link
php artisan optimize:clear
```

File challenge akan disimpan di:

```txt
storage/app/public/challenges
```

Dan bisa diakses dari browser melalui:

```txt
/storage/challenges/nama-file
```

---

## Setup CSS

Project ini dapat memakai CSS langsung dari folder `public/css`.

Jalankan:

```bash
mkdir -p public/css
cp resources/css/app.css public/css/app.css
```

Jika memakai Vite, jalankan:

```bash
npm run build
```

Untuk development mode:

```bash
npm run dev
```

Namun untuk akses lewat jaringan lokal atau HP, disarankan memakai CSS public biasa atau hasil build:

```bash
npm run build
```

---

## Jalankan Project

Untuk menjalankan di localhost:

```bash
php artisan serve
```

Buka di browser:

```txt
http://localhost:8000
```

Atau:

```txt
http://127.0.0.1:8000
```

---

## Jalankan agar Bisa Diakses Lewat Jaringan Lokal

Jalankan Laravel dengan host `0.0.0.0`:

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

Cari IP laptop:

### Windows CMD

```cmd
ipconfig
```

Gunakan IP dari adapter Wi-Fi.

Contoh:

```txt
192.168.1.6
```

Lalu akses dari HP atau laptop lain yang satu jaringan:

```txt
http://192.168.1.6:8000
```

---

## Akses Lokal dari WSL

Jika project dijalankan dari WSL dan ingin diakses oleh HP/teman satu WiFi, kadang perlu port forwarding dari Windows ke WSL.

Cek IP WSL:

```bash
ip addr
```

Contoh IP WSL:

```txt
172.31.106.142
```

Cek IP Windows:

```cmd
ipconfig
```

Contoh IP Wi-Fi Windows:

```txt
192.168.1.6
```

Buka CMD atau PowerShell sebagai Administrator, lalu jalankan:

```cmd
netsh interface portproxy add v4tov4 listenaddress=0.0.0.0 listenport=8000 connectaddress=IP_WSL connectport=8000
```

Contoh:

```cmd
netsh interface portproxy add v4tov4 listenaddress=0.0.0.0 listenport=8000 connectaddress=172.31.106.142 connectport=8000
```

Tambahkan rule firewall:

```cmd
netsh advfirewall firewall add rule name="Laravel OSINT Arena 8000" dir=in action=allow protocol=TCP localport=8000
```

Akses dari HP:

```txt
http://192.168.1.6:8000
```

---

## Struktur Halaman

Halaman umum:

```txt
/
/login
/register
/rules
```

Halaman user:

```txt
/dashboard
/profile
/challenges
/challenges/{slug}
/scoreboard
```

Halaman admin:

```txt
/admin
/admin/challenges
/admin/challenges/create
/admin/challenges/{id}/edit
/admin/users
/admin/submissions
```

---

## Cara Menggunakan Admin Panel

Login sebagai admin, lalu buka:

```txt
/admin
```

Admin dapat:

- Membuat challenge OSINT
- Mengedit challenge
- Menghapus challenge
- Upload file soal
- Mengatur max points
- Mengatur min points
- Mengatur decay per solve
- Mengisi flag
- Melihat daftar user
- Melihat submission benar dan salah

---

## Format Flag

Format flag yang digunakan:

```txt
{jawaban}
```

Contoh:

```txt
{pelabuhan_merak}
{jakarta_selatan}
{hidden_location}
```

Flag tidak wajib memakai prefix seperti:

```txt
OSINTCTF{...}
```

---

## Dynamic Scoring

Sistem scoring menggunakan dynamic scoring.

Setiap challenge memiliki:

```txt
Max Points
Min Points
Decay Per Solve
```

Contoh:

```txt
Max Points      : 500
Min Points      : 100
Decay Per Solve : 50
```

Maka poin yang didapat peserta:

```txt
Solver pertama  : 500
Solver kedua    : 450
Solver ketiga   : 400
Solver keempat  : 350
```

Jika poin sudah turun sampai `Min Points`, maka poin tidak akan turun lagi.

Rumus:

```txt
points_awarded = max(min_points, max_points - (jumlah_solve_sebelumnya * decay_per_solve))
```

Poin yang sudah didapat peserta sebelumnya tidak ikut turun.

---

## Scoreboard

Scoreboard menampilkan:

- Rank
- Team Name
- Score
- Solves
- Last Solve

Rank 1 sampai 3 tampil sebagai podium.

Rank 4 dan seterusnya tampil dalam tabel.

Scoreboard mengambil data dari route:

```txt
/scoreboard/data
```

Interval auto update bisa diubah di file:

```txt
resources/views/scoreboard/index.blade.php
```

Cari:

```js
setInterval(loadScoreboard, 50000);
```

Keterangan:

```txt
3000  = 3 detik
5000  = 5 detik
50000 = 50 detik
```

---

## Preview Gambar Challenge

Jika admin mengupload file gambar seperti:

```txt
jpg
jpeg
png
webp
gif
```

Maka gambar akan langsung tampil di halaman detail challenge.

Jika file bukan gambar seperti:

```txt
zip
pdf
txt
docx
pcap
```

Maka user dapat membuka atau mengunduh file melalui tombol `Open / Download`.

---

## Popup Submit Flag

Saat user submit flag:

```txt
Flag benar  -> muncul popup Flag Benar
Flag salah  -> muncul popup Flag Salah
Sudah solve -> muncul popup Sudah Solved
```

Popup tidak menggunakan sound.

---

## Perintah Penting

Reset database dan isi ulang seeder:

```bash
php artisan migrate:fresh --seed
```

Reset database tanpa seeder:

```bash
php artisan migrate:fresh
```

Membersihkan cache Laravel:

```bash
php artisan optimize:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear
```

Membuat cache agar lebih cepat:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
composer dump-autoload -o
```

Menjalankan server lokal:

```bash
php artisan serve
```

Menjalankan server untuk jaringan lokal:

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

---

## Jika CSS Tidak Muncul

Jalankan:

```bash
mkdir -p public/css
cp resources/css/app.css public/css/app.css
php artisan optimize:clear
php artisan view:clear
```

Refresh browser dengan:

```txt
CTRL + F5
```

Pastikan layout memakai:

```blade
<link rel="stylesheet" href="{{ asset('css/app.css') }}?v=1.0.0">
```

Jika memakai Vite, pastikan file ini ada:

```txt
public/build/manifest.json
```

Jika belum ada, jalankan:

```bash
npm run build
```

---

## Jika Upload Gambar Tidak Muncul

Jalankan:

```bash
rm -rf public/storage
php artisan storage:link
php artisan optimize:clear
php artisan view:clear
```

Cek file upload:

```bash
ls storage/app/public/challenges
```

Coba buka langsung dari browser:

```txt
http://localhost:8000/storage/challenges/NAMA_FILE
```

Jika masih 404, upload ulang file challenge dari admin panel.

---

## Jika Website Lambat di WSL

Jangan jalankan project dari folder Windows seperti:

```txt
/mnt/c/...
```

Pindahkan ke filesystem WSL:

```bash
mkdir -p ~/projects
cp -a "/mnt/c/Users/HYPE AMD/Documents/projekpp-osintarena" ~/projects/
cd ~/projects/projekpp-osintarena
```

Project Laravel akan lebih cepat jika berada di:

```txt
/home/username/projects/projekpp-osintarena
```

---

## Workflow Git untuk Kerja Bareng

Sebelum mulai edit:

```bash
git pull origin main
```

Buat branch baru:

```bash
git checkout -b nama-fitur
```

Contoh:

```bash
git checkout -b update-scoreboard
```

Setelah selesai edit:

```bash
git add .
git commit -m "Update scoreboard layout"
git push origin nama-fitur
```

Lalu buat Pull Request di GitHub.

Jika langsung kerja di branch main:

```bash
git pull origin main
git add .
git commit -m "Update fitur"
git push origin main
```

---

## File yang Tidak Boleh Di-commit

Jangan commit file atau folder ini:

```txt
.env
vendor/
node_modules/
database/database.sqlite
storage/app/public/challenges/
public/storage
```

Pastikan `.gitignore` berisi:

```gitignore
/vendor
/node_modules
.env
/database/database.sqlite
/storage/app/public/challenges/*
/public/storage
/public/hot
/public/build
```

---

## Setup Cepat dari Nol

Untuk teman yang baru clone project, jalankan:

```bash
git clone https://github.com/USERNAME/projekpp-osintarena.git
cd projekpp-osintarena

composer install
npm install

cp .env.example .env
php artisan key:generate

touch database/database.sqlite
php artisan migrate:fresh --seed

php artisan storage:link

mkdir -p public/css
cp resources/css/app.css public/css/app.css

php artisan optimize:clear
php artisan serve
```

Buka:

```txt
http://localhost:8000
```

Login admin:

```txt
Username : admin
Password : mantaganteng
```

Jika password admin sudah diubah, cek di:

```txt
database/seeders/AdminSeeder.php
```

---

## Catatan

Project ini masih MVP dan bisa dikembangkan lagi.

Fitur yang bisa ditambahkan ke depannya:

- Export scoreboard
- Import challenge
- Hint system
- Timer event
- Pengaturan event dari admin
- Reset scoreboard dari admin
- Theme mode
- WebSocket realtime
- Multi event
- Role panitia
- Anti brute force submit flag

