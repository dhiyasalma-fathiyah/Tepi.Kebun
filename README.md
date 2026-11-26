# Tepi Kebun

Aplikasi web pasokan buah segar B2B (Laravel) — KBPR207 Web Framework, Assessment II (Lab).

## Fitur / komponen

| Komponen | Implementasi |
|---|---|
| Migration | `database/migrations` — `products`, `team_members`, `contacts` (FK `contacts.product_id`, soft deletes) |
| Eloquent ORM | `app/Models` — relasi `Product hasMany Contact`, scope, accessor, SoftDeletes |
| Controller | `app/Http/Controllers` — resource controller (+ `trashed`, `restore`) |
| Collection | `ProductController::summarize()` — `count`, `sum`, `avg`, `countBy`, `pluck`, `unique`, `sort` |
| Form Processing & Validation | `app/Http/Requests` (FormRequest) + `@error` / `old()` di Blade |
| CRUD | Produk, Tim, dan Pesan Kontak (hapus = soft delete, bisa dipulihkan) |

## Menjalankan

```bash
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate:fresh --seed
php artisan serve
```

## Rute utama

- `/products` — katalog produk (cari, filter grade, tambah, edit, hapus)
- `/team-members` — tim
- `/contact-us` — form publik; `/contacts` — pesan masuk
