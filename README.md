# Tepi Kebun — Web Framework Assessment II

Aplikasi Laravel untuk pasokan buah segar B2B: katalog buah + foto, **form pemesanan** (gaya marketplace),
**form hubungi kami** (FAQ, email, WhatsApp), dan **dashboard admin** yang dilindungi route middleware.

## Pemetaan komponen Assessment II

| Komponen | Lokasi |
|---|---|
| Migration | `database/migrations/*` (categories, products, orders, order_items, contacts, team_members, users.is_admin) |
| Eloquent ORM + relasi | `app/Models/*` — `Category hasMany Product`, `Order hasMany OrderItem`, `OrderItem belongsTo Product`, SoftDeletes |
| Controller | `app/Http/Controllers/*` (publik) dan `app/Http/Controllers/Admin/*` |
| Collection | `CatalogController` (filter/countBy), `OrderController` (map/sum/keyBy), `Admin\DashboardController` (groupBy/sum/pluck/sortDesc/take), `ContactController` (groupBy FAQ) |
| Form processing & validation | `app/Http/Requests/*` (+ validasi stok, upload foto jpg/png/webp maks 2 MB) |
| CRUD + soft delete | Admin: Buah, Kategori, Pesanan, Pesan Masuk, Tim (tab "Terhapus" + tombol Pulihkan) |
| Route middleware | `routes/web.php` grup `/admin` → `auth` + `is_admin` (`app/Http/Middleware/EnsureUserIsAdmin.php`, alias di `bootstrap/app.php`) |
| Mail | `app/Mail/ContactMessageMail.php` + `resources/views/emails/contact-message.blade.php` |

## Setup lokal

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite        # DB default: SQLite (atau ubah DB_* di .env ke MySQL)
php artisan migrate:fresh --seed      # migrasi + data 14 buah, 5 kategori, admin, pesanan contoh
php artisan storage:link              # agar foto di storage/app/public bisa diakses
php artisan serve                     # http://localhost:8000
```

> Gunakan `migrate:fresh` (bukan `migrate`) karena migrasi `products`, `contacts`, dan `team_members` diperbarui.
> Pastikan `APP_URL` di `.env` sama dengan alamat `php artisan serve` agar URL foto benar.

### Akun admin (seeder)

| | |
|---|---|
| Login | `http://localhost:8000/login` |
| Email | `admin@tepikebun.test` (`ADMIN_EMAIL`) |
| Password | `password123` (`ADMIN_PASSWORD`) — **ganti sebelum produksi** |
| Non-admin (uji 403) | `user@tepikebun.test` / `password123` |

### Konfigurasi `.env`

```dotenv
ADMIN_EMAIL=admin@tepikebun.test      # penerima email dari form Hubungi Kami
WHATSAPP_NUMBER=6281234567890         # format internasional tanpa +
BANK_NAME=BCA
BANK_ACCOUNT="1234 5678 90"
BANK_HOLDER="Tepi Kebun"

# Email — default MAIL_MAILER=log (isi email ditulis ke storage/logs/laravel.log).
# Untuk SMTP sungguhan (contoh Mailtrap/Gmail):
# MAIL_MAILER=smtp
# MAIL_HOST=sandbox.smtp.mailtrap.io
# MAIL_PORT=2525
# MAIL_USERNAME=...
# MAIL_PASSWORD=...
```

Bila SMTP gagal, pesan tetap tersimpan di database, error dicatat di log, dan pengunjung melihat pemberitahuan — aplikasi tidak crash.

### Foto buah

Seeder menyalin 14 ilustrasi contoh ke `storage/app/public/products`. Ganti dengan foto asli lewat
**Admin → Data Buah → Edit → Foto** (JPG/PNG/WEBP, maks 2 MB). Produk tanpa foto menampilkan ikon kategori.

### Test

```bash
php artisan test
```
