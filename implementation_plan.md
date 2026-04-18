# Improvement Plan — Melly Salon Management System

Perbaikan menyeluruh untuk meningkatkan keamanan, fitur, code quality, dan UX.

## User Review Required

> [!IMPORTANT]
> **Semua perubahan di bawah ini akan dilakukan dalam satu sesi.** Plan ini terbagi menjadi 5 fase masing-masing independen. Jika ada fase yang tidak diinginkan, beritahu saya.

> [!WARNING]
> **Fase 3 (Void Transaksi)** menambah route dan controller method baru. Pastikan tidak ada konflik dengan fitur lain yang sedang dikerjakan.

---

## Proposed Changes

### Fase 1 — Keamanan (Quick Wins)

#### 1a. Rate Limiting Login
Mencegah brute-force attack pada halaman login.

#### [MODIFY] [web.php](file:///d:/latihan%20coding%20otodidak/antigravity/mellySalonSystemManagement/routes/web.php)
- Tambahkan middleware `throttle:5,1` pada route `POST /login` (max 5 percobaan per menit)

#### [MODIFY] [login.blade.php](file:///d:/latihan%20coding%20otodidak/antigravity/mellySalonSystemManagement/resources/views/auth/login.blade.php)
- Tampilkan pesan error rate limit yang user-friendly: "Terlalu banyak percobaan login. Coba lagi dalam X detik."

---

#### 1b. Soft Deletes pada Service & Member
Data yang dihapus tidak hilang permanen, bisa di-restore.

#### [NEW] Migration: `add_soft_deletes_to_services_table.php`
- Tambah kolom `deleted_at` ke tabel `services`

#### [NEW] Migration: `add_soft_deletes_to_members_table.php`
- Tambah kolom `deleted_at` ke tabel `members`

#### [MODIFY] [Service.php](file:///d:/latihan%20coding%20otodidak/antigravity/mellySalonSystemManagement/app/Models/Service.php)
- Tambah trait `SoftDeletes`

#### [MODIFY] [Member.php](file:///d:/latihan%20coding%20otodidak/antigravity/mellySalonSystemManagement/app/Models/Member.php)
- Tambah trait `SoftDeletes`

---

### Fase 2 — Database Improvements

#### 2a. Tambah Index untuk Performa Query

#### [NEW] Migration: `add_indexes_to_transactions_table.php`
- Index pada `status`, `created_at`, `payment_method`

#### 2b. Fix Birthday Column

#### [NEW] Migration: `change_bday_to_date_on_members_table.php`
- Ubah kolom `bday` dari `string` ke `date` (nullable)

#### [MODIFY] [modals.blade.php](file:///d:/latihan%20coding%20otodidak/antigravity/mellySalonSystemManagement/resources/views/partials/modals.blade.php)
- Input `m-bday` diubah dari `type="text"` ke `type="date"` dengan date picker

#### [MODIFY] [MemberController.php](file:///d:/latihan%20coding%20otodidak/antigravity/mellySalonSystemManagement/app/Http/Controllers/MemberController.php)
- Validasi `bday` diubah ke `nullable|date`

#### [MODIFY] [Member.php](file:///d:/latihan%20coding%20otodidak/antigravity/mellySalonSystemManagement/app/Models/Member.php)
- Tambah cast `birthday => 'date'`

#### [MODIFY] [ReportController.php](file:///d:/latihan%20coding%20otodidak/antigravity/mellySalonSystemManagement/app/Http/Controllers/ReportController.php)
- Ganti query birthday member dari `LOWER(bday) LIKE ...` menjadi `whereMonth('bday', ...)`

#### [MODIFY] [members.js](file:///d:/latihan%20coding%20otodidak/antigravity/mellySalonSystemManagement/resources/js/modules/members.js)
- Update render dan form handling untuk format `date` baru

#### [MODIFY] [dashboard.js](file:///d:/latihan%20coding%20otodidak/antigravity/mellySalonSystemManagement/resources/js/modules/dashboard.js)
- Update tampilan birthday member di dashboard

---

### Fase 3 — Fitur Void/Batalkan Transaksi

Status `voided` sudah ada di database design tapi belum ada implementasinya.

#### [MODIFY] [web.php](file:///d:/latihan%20coding%20otodidak/antigravity/mellySalonSystemManagement/routes/web.php)
- Tambah route `PATCH /transactions/{id}/void`

#### [MODIFY] [TransactionController.php](file:///d:/latihan%20coding%20otodidak/antigravity/mellySalonSystemManagement/app/Http/Controllers/TransactionController.php)
- Tambah method `void()`: ubah status → `voided`, batalkan poin & total_spent member

#### [MODIFY] [history.blade.php](file:///d:/latihan%20coding%20otodidak/antigravity/mellySalonSystemManagement/resources/views/pages/history.blade.php)
- Tambah kolom Status di tabel + tombol "Void" pada setiap baris transaksi

#### [MODIFY] [modals.blade.php](file:///d:/latihan%20coding%20otodidak/antigravity/mellySalonSystemManagement/resources/views/partials/modals.blade.php)
- Tambah modal konfirmasi void transaksi

#### [MODIFY] [invoice.js](file:///d:/latihan%20coding%20otodidak/antigravity/mellySalonSystemManagement/resources/js/modules/invoice.js)
- Tambah fungsi `voidTransaction()` dan render status badge (completed/voided)

#### [MODIFY] [api.js](file:///d:/latihan%20coding%20otodidak/antigravity/mellySalonSystemManagement/resources/js/modules/api.js)
- Tambah `voidTransaction(id)` API call

#### [MODIFY] [app.js](file:///d:/latihan%20coding%20otodidak/antigravity/mellySalonSystemManagement/resources/js/app.js)
- Expose fungsi void ke `window.SalonApp`

---

### Fase 4 — Search & Pagination pada Riwayat Transaksi

#### [MODIFY] [TransactionController.php](file:///d:/latihan%20coding%20otodidak/antigravity/mellySalonSystemManagement/app/Http/Controllers/TransactionController.php)
- Method `index()`: tambah query parameter `search` (by customer_name/invoice_number) dan `per_page` untuk pagination

#### [MODIFY] [history.blade.php](file:///d:/latihan%20coding%20otodidak/antigravity/mellySalonSystemManagement/resources/views/pages/history.blade.php)
- Tambah search bar dan pagination controls (prev/next + page info)

#### [MODIFY] [invoice.js](file:///d:/latihan%20coding%20otodidak/antigravity/mellySalonSystemManagement/resources/js/modules/invoice.js)
- Update `loadTransactionHistory()` untuk mendukung search + pagination
- Render pagination controls

#### [MODIFY] [api.js](file:///d:/latihan%20coding%20otodidak/antigravity/mellySalonSystemManagement/resources/js/modules/api.js)
- Update `fetchTransactions()` untuk mendukung parameter pagination

---

### Fase 5 — Code Cleanup & Responsive

#### 5a. Hapus File Orphan

#### [DELETE] [salon-cantik.html](file:///d:/latihan%20coding%20otodidak/antigravity/mellySalonSystemManagement/salon-cantik.html)
- File template lama 47KB yang tidak dipakai

#### 5b. Bersihkan Dead CSS

#### [MODIFY] [app.css](file:///d:/latihan%20coding%20otodidak/antigravity/mellySalonSystemManagement/resources/css/app.css)
- Hapus CSS custom properties dan component styles yang tidak terpakai (views menggunakan full Tailwind)
- Pertahankan hanya: `@import "tailwindcss"`, `@theme`, `.page`/`.page.active`, `.hidden`, animasi modal, dan styles yang masih direferensi

#### 5c. Fix Responsive Sidebar

#### [MODIFY] [sidebar.blade.php](file:///d:/latihan%20coding%20otodidak/antigravity/mellySalonSystemManagement/resources/views/partials/sidebar.blade.php)
- Tambah class `hidden md:flex` agar sidebar tersembunyi default di mobile
- Tambah overlay backdrop saat sidebar terbuka di mobile

#### [MODIFY] [navigation.js](file:///d:/latihan%20coding%20otodidak/antigravity/mellySalonSystemManagement/resources/js/modules/navigation.js)
- Perbaiki `toggleSidebar()` untuk toggle dengan animasi slide + overlay backdrop

---

## Open Questions

> [!IMPORTANT]
> **Mengenai migrasi kolom `bday`:** Data birthday yang sudah ada dalam format "12 Mar" akan perlu dikonversi ke format date (`YYYY-MM-DD`). Karena datanya ditambahkan dari seeder kosong, kemungkinan tabel member masih kosong/sedikit. **Apakah boleh saya reset kolom bday saja** (data lama di-null-kan), atau kamu ingin saya buat konversi otomatis?

---

## Verification Plan

### Automated Tests
```bash
php artisan migrate          # Pastikan semua migrasi berjalan
php artisan serve            # Jalankan server
```

### Manual Verification (Browser)
1. **Login** — Test rate limiting: login salah 6x, pastikan muncul pesan throttle
2. **Riwayat** — Cari transaksi via search bar, navigasi pagination
3. **Void** — Buka riwayat, klik void pada transaksi, pastikan status berubah & poin dibatalkan
4. **Member** — Buat member baru dengan date picker birthday
5. **Mobile** — Resize browser ke mobile, test hamburger menu & sidebar overlay
6. **Delete** — Hapus service/member, pastikan soft-deleted (tidak muncul tapi masih di DB)
