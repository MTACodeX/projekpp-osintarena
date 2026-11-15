# OSINT Arena

**OSINT Arena** adalah platform *Capture The Flag* (CTF) berbasis web yang berfokus pada tantangan *Open-Source Intelligence* (OSINT). Platform ini dirancang untuk latihan, pembelajaran, dan penyelenggaraan kompetisi skala kecil, dengan alur peserta, pengelolaan tantangan, penilaian, dan papan peringkat dalam satu aplikasi.

Dibangun dengan Laravel dan Blade, OSINT Arena dapat dijalankan secara lokal maupun di jaringan internal untuk kebutuhan pengembangan dan simulasi acara.

## Fitur

### Peserta

- Registrasi dan login menggunakan username.
- Satu akun mewakili satu tim, dengan nama tim yang dapat dipilih sendiri atau dibuat secara acak.
- Daftar tantangan OSINT beserta halaman detailnya.
- Pratinjau gambar dan akses berkas pendukung tantangan.
- Pengiriman flag dengan informasi hasil: benar, salah, atau sudah diselesaikan.
- Scoreboard dengan podium tiga besar dan daftar peringkat berikutnya yang diperbarui secara berkala.

### Administrator

- Dashboard dan pengelolaan tantangan (tambah, edit, hapus).
- Unggah berkas pendukung tantangan serta penentuan flag.
- Pengaturan *maximum points*, *minimum points*, dan *decay per solve*.
- Pemantauan akun peserta serta riwayat submission.

## Teknologi

| Komponen | Teknologi |
| --- | --- |
| Backend | PHP, Laravel |
| Antarmuka | Blade, CSS, JavaScript |
| Database | SQLite |
| Dependency & build | Composer, npm |
| Version control | Git, GitHub |

## Menjalankan secara lokal

### Prasyarat

Pastikan PHP dengan ekstensi SQLite, Composer, Node.js, npm, dan Git sudah tersedia. Versi yang dibutuhkan mengikuti berkas `composer.json` dan `package.json` dalam repository.

### Instalasi

1. Clone repository dan masuk ke folder project:

   ```bash
   git clone https://github.com/MTACodeX/projekpp-osintarena.git
   cd projekpp-osintarena
   ```

2. Pasang dependency:

   ```bash
   composer install
   npm install
   ```

3. Buat konfigurasi environment dan application key:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Sesuaikan konfigurasi di `.env`, terutama koneksi database:

   ```dotenv
   APP_NAME="OSINT Arena"
   APP_ENV=local
   APP_DEBUG=true
   APP_URL=http://localhost:8000

   DB_CONNECTION=sqlite
   ```

   `APP_KEY` diisi otomatis oleh perintah `php artisan key:generate`; jangan menimpanya dengan nilai kosong.

5. Siapkan database dan data awal:

   ```bash
   touch database/database.sqlite
   php artisan migrate --seed
   ```

   > **Perhatian:** `php artisan migrate:fresh --seed` akan menghapus seluruh tabel dan membuatnya kembali. Gunakan hanya jika memang ingin mereset database pengembangan.

6. Hubungkan penyimpanan file publik dan siapkan aset frontend:

   ```bash
   php artisan storage:link
   npm run build
   ```

7. Jalankan server:

   ```bash
   php artisan serve --host=127.0.0.1 --port=8000
   ```

   Buka **http://localhost:8000** di browser.

### Akun administrator

Akun admin awal disiapkan melalui `database/seeders/AdminSeeder.php` saat proses seeding. Periksa konfigurasi seeder untuk kredensial pengembangan, kemudian **ganti password bawaan sebelum aplikasi dibagikan atau diakses melalui jaringan**.

> Project ini ditujukan untuk pengembangan dan simulasi. Jangan gunakan kredensial bawaan, `APP_DEBUG=true`, atau Laravel development server sebagai konfigurasi deployment publik.

## Menggunakan aplikasi

1. Peserta membuat akun atau login, lalu memilih tantangan di halaman **Challenges**.
2. Peserta memeriksa deskripsi dan berkas pendukung untuk menemukan flag.
3. Flag dikirim lewat halaman detail tantangan. Aplikasi memberikan umpan balik atas submission.
4. Poin dari penyelesaian yang valid ditambahkan ke skor tim dan ditampilkan di **Scoreboard**.
5. Administrator mengelola tantangan, parameter poin, peserta, dan riwayat submission melalui panel admin.

### Halaman utama

| Akses | Path |
| --- | --- |
| Beranda | `/` |
| Login / Register | `/login`, `/register` |
| Aturan | `/rules` |
| Dashboard peserta | `/dashboard` |
| Profil | `/profile` |
| Daftar dan detail tantangan | `/challenges`, `/challenges/{slug}` |
| Scoreboard | `/scoreboard` |
| Panel admin | `/admin` |
| Kelola tantangan | `/admin/challenges` |
| Peserta dan submission | `/admin/users`, `/admin/submissions` |

Sebagian halaman memerlukan autentikasi atau hak akses administrator.

## Sistem penilaian

OSINT Arena menggunakan **dynamic scoring**: poin suatu tantangan berkurang ketika semakin banyak peserta menyelesaikannya, tetapi tidak turun di bawah batas minimum.

```text
points_awarded = max(min_points, max_points - (previous_solves * decay_per_solve))
```

Sebagai contoh, jika sebuah tantangan memiliki `max_points = 500`, `min_points = 100`, dan `decay_per_solve = 50`, maka empat penyelesaian pertama masing-masing memperoleh **500, 450, 400, dan 350 poin**. Skor yang sudah diperoleh peserta sebelumnya tidak dihitung ulang.

Format flag menggunakan tanda kurung kurawal, misalnya `{contoh_jawaban}`. Tidak diperlukan prefix khusus seperti `OSINTCTF`.

## Berkas tantangan

Administrator dapat mengunggah gambar (`jpg`, `jpeg`, `png`, `webp`, `gif`) untuk ditampilkan langsung pada detail tantangan. Berkas lain, seperti `pdf`, `zip`, atau `txt`, dapat disediakan sebagai lampiran untuk dibuka atau diunduh.

Penyimpanan publik menggunakan direktori `storage/app/public/challenges` dan URL `/storage/challenges/...` setelah `php artisan storage:link` dijalankan.

## Akses melalui jaringan lokal (opsional)

Untuk pengujian dari perangkat lain pada Wi-Fi yang sama, jalankan server dengan alamat bind seluruh interface:

```bash
php artisan serve --host=0.0.0.0 --port=8000
```

Kemudian buka `http://IP-KOMPUTER:8000` dari perangkat lain. Pastikan firewall mengizinkan koneksi pada port tersebut.

Pada **WSL2**, IP internal WSL umumnya tidak dapat diakses langsung dari HP. Tergantung konfigurasi jaringan WSL, akses dapat membutuhkan *port forwarding* dari Windows ke IP WSL serta aturan Windows Firewall. Alamat IP dan port harus disesuaikan dengan perangkat masing-masing; contoh konfigurasi lokal tidak dijadikan pengaturan permanen dalam repository.

> Gunakan hanya di jaringan tepercaya. Untuk deployment yang dapat diakses publik, gunakan web server dan konfigurasi production yang sesuai.

## Troubleshooting

**Style/CSS tidak tampil**

```bash
npm run build
php artisan optimize:clear
```

Jika project menggunakan stylesheet langsung dari `public/css/app.css`, pastikan berkas tersebut tersedia dan dirujuk dengan benar pada layout Blade. Jika memakai Vite, pastikan hasil build tersimpan di `public/build`.

**Gambar atau lampiran tantangan tidak tampil**

```bash
php artisan storage:link
php artisan optimize:clear
```

Pastikan berkas benar-benar ada di `storage/app/public/challenges` dan memiliki izin baca yang sesuai. Jangan menghapus folder penyimpanan sebelum memeriksa isinya.

**Perubahan konfigurasi belum diterapkan**

```bash
php artisan optimize:clear
```

**Kinerja WSL lambat**

Untuk pengembangan di WSL, simpan repository di filesystem Linux (misalnya `~/projects/projekpp-osintarena`), bukan di `/mnt/c/...`, bila operasi file terasa lambat.

## Pengembangan dan kontribusi

Untuk pekerjaan bersama, buat branch terpisah, lakukan perubahan, lalu ajukan Pull Request:

```bash
git pull origin main
git checkout -b nama-fitur
# Lakukan perubahan dan pengujian
git add .
git commit -m "Add feature description"
git push -u origin nama-fitur
```

Sebelum push, pastikan file `.env`, database lokal, hasil unggahan privat, folder `vendor`, dan `node_modules` tidak ikut ter-commit. Periksa aturan `.gitignore` dan jalankan `git status`.

## Status pengembangan

OSINT Arena masih berada pada tahap **MVP** dan terbuka untuk pengembangan lebih lanjut. Beberapa ide pengembangan berikutnya meliputi sistem hint, pengaturan durasi event, ekspor scoreboard, pengelolaan banyak event, dan pembaruan peringkat secara real-time.

---

**Repository:** [MTACodeX/projekpp-osintarena](https://github.com/MTACodeX/projekpp-osintarena)
