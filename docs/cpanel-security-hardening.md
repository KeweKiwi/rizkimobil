# Rizki Mobil cPanel Security Hardening

Checklist ini berlaku untuk deployment production `rizkimobil.com`. Jalankan setelah backup database dan media yang tervalidasi. Jangan menyalin `.env.example` langsung ke production.

## P0: Lakukan Sekarang

1. Rotasi password seluruh akun admin yang pernah memakai kredensial bootstrap lama.
   - Gunakan password unik minimal 16 karakter atau passphrase panjang.
   - Jangan memasukkan password ke Git, tiket, chat publik, atau command history.
   - Setelah branch hardening terpasang, perubahan password akan merotasi remember token dan sesi lama akan ditolak melalui `auth.session`.
   - Audit tabel `users` untuk akun admin yang tidak dikenal.

2. Jangan gunakan `vendor.zip` lama.
   - Arsip tersebut berisi dependency lama dan development packages.
   - Hapus salinannya dari `public_html` dan deployment artifact setelah memastikan Composer production install berhasil.
   - Jangan mengekstraknya lagi setelah `composer.lock` diperbarui.

3. Pilih PHP 8.3 atau 8.4 di MultiPHP Manager.
   - Aktifkan ekstensi: `ctype`, `dom`, `fileinfo`, `filter`, `intl`, `json`, `mbstring`, `openssl`, `session`, `tokenizer`, `xmlreader`, dan `zip`.
   - Jalankan `composer check-platform-reqs --no-dev` dari runtime hosting.

## Document Root Dan File

Struktur yang direkomendasikan:

```text
/home/ACCOUNT/rizkimobil/          # app, vendor, .env, storage, routes
/home/ACCOUNT/rizkimobil/public/   # satu-satunya document root domain
```

Di cPanel Domains, document root `rizkimobil.com` harus menunjuk tepat ke folder `public/`. Jangan menempatkan `.env`, `.git`, `artisan`, `composer.*`, `vendor`, `app`, `config`, `database`, `routes`, atau `storage/logs` di document root.

Permission awal:

```text
.env                         600
file umum                    644
directory umum               755
storage/                     writable hanya oleh user PHP
bootstrap/cache/             writable hanya oleh user PHP
```

Jangan gunakan permission `777`.

Setelah deployment, path berikut wajib menghasilkan `403` atau `404`, bukan konten file dan bukan halaman sukses `200`:

```text
/.env
/.git/HEAD
/composer.json
/composer.lock
/artisan
/vendor.zip
/storage/logs/laravel.log
/database.sqlite
/backup.zip
/database.sql
```

## Environment Production

Nilai minimum yang harus diverifikasi di `.env` production:

```dotenv
APP_ENV=production
APP_DEBUG=false
APP_URL=https://rizkimobil.com

LOG_CHANNEL=daily
LOG_LEVEL=warning
LOG_DAILY_DAYS=14

SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax
SESSION_DOMAIN=null

MAIL_MAILER=smtp
```

Gunakan `APP_KEY` production yang sudah ada. Jangan merotasi `APP_KEY` hanya karena audit, karena rotasi dapat membatalkan session dan data terenkripsi.

Database production tidak boleh memakai akun MySQL `root`. Berikan hanya privilege database Rizki Mobil yang memang diperlukan aplikasi. Matikan akses remote MySQL bila tidak dibutuhkan.

## Deployment Command

Gunakan lockfile yang ada di branch hardening:

```bash
composer install --no-dev --prefer-dist --optimize-autoloader --classmap-authoritative
composer audit --locked --no-dev
composer check-platform-reqs --no-dev
php artisan migrate --force
php artisan optimize
```

Build Vite dapat dibuat di CI/mesin pengembangan Node 24 LTS lalu folder `public/build` dideploy. Jangan menjalankan Vite dev server di production.

Setelah mengganti `.env` atau source:

```bash
php artisan optimize:clear
php artisan optimize
```

## OpenResty Dan HTTPS

Pemeriksaan 22 Agustus 2026 menunjukkan keempat URL berikut mengembalikan `200`, bukan redirect canonical:

```text
http://rizkimobil.com
https://rizkimobil.com
http://www.rizkimobil.com
https://www.rizkimobil.com
```

Minta provider/cPanel mengatur edge OpenResty agar:

1. Semua HTTP melakukan redirect permanen ke `https://rizkimobil.com$request_uri`.
2. Host `www` melakukan redirect permanen ke host apex.
3. Origin hanya menerima traffic dari proxy OpenResty yang sah.
4. `X-Forwarded-For` dan `X-Forwarded-Proto` dari client ditimpa, bukan dipercaya atau ditambahkan mentah.
5. Header versi `Server` disembunyikan.
6. HSTS ditambahkan pada response HTTPS setelah redirect dipastikan stabil:

```text
Strict-Transport-Security: max-age=31536000
```

Jangan menambah `includeSubDomains` atau `preload` sebelum seluruh subdomain terverifikasi HTTPS.

`bootstrap/app.php` masih memakai `trustProxies('*')` karena IP/CIDR OpenResty belum diketahui. Ganti wildcard dengan IP/CIDR proxy nyata setelah provider memberikannya. Sampai itu dilakukan, rate limit berbasis IP bergantung pada OpenResty untuk membersihkan forwarded headers dan akses langsung ke origin harus diblokir.

## Upload Media

Branch hardening memaksa nama foto menjadi ULID dan mengambil ekstensi dari MIME server-side. Apache juga menolak eksekusi PHP di `public/images/cars/.htaccess`.

OpenResty tidak membaca `.htaccess`. Minta provider menambahkan aturan no-execute ekuivalen untuk `/images/cars/`: file dengan ekstensi PHP, PHTML, PHAR, atau handler script lain harus ditolak dan tidak pernah diteruskan ke PHP-FPM.

Jangka menengah, pindahkan upload runtime ke `storage/app/public` dengan symlink persistent atau object storage/CDN. Jangan mencampur media customer dengan release Git.

## Backup Dan Monitoring

- Simpan backup database dan media di luar document root.
- Gunakan JetBackup atau storage remote terenkripsi dan uji restore berkala.
- Jangan menyimpan `.sql`, `.zip`, `.tar.gz`, atau log di `public_html`.
- Pantau login admin gagal, lonjakan `429`, error `5xx`, dan perubahan akun admin.
- Jadwalkan `composer audit --locked --no-dev` dan `npm audit` pada CI atau minimal setiap pembaruan deployment.

## Verifikasi Akhir

Sesudah deployment:

1. Jalankan seluruh test lokal/CI.
2. Verifikasi login user, login admin, CRUD mobil, lokasi, user, upload, favorites, kontak, dan ganti password.
3. Periksa cookie session dari browser: `Secure`, `HttpOnly`, `SameSite=Lax`, tanpa `Domain` bila tidak diperlukan.
4. Periksa header HTML final setelah challenge OpenResty, bukan hanya halaman challenge.
5. Ulangi pemeriksaan sensitive paths dan pastikan status `403/404`.
6. Pastikan perubahan password admin memutus sesi lama.
