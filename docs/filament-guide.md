# Filament Admin Panel — Panduan untuk Pemula

> Ini adalah panduan khusus untuk project **Rizki Mobil Indonesia**. Ditulis agar mudah dipahami walau kamu baru pertama kali pakai Filament.

---

## Apa itu Filament?

**Filament** adalah library Laravel yang membangun admin panel secara otomatis dari kode PHP.

Dibandingkan membuat halaman admin manual (buat controller, buat view, buat form HTML, dll), Filament cukup dengan satu file dan semuanya langsung ada: tabel, form, tombol CRUD, validasi, upload foto, dll.

Di project ini, Filament 4.0 digunakan untuk panel admin di `/admin`.

---

## Struktur File Filament di Project Ini

```
app/
├── Filament/
│   ├── Resources/
│   │   └── Cars/
│   │       ├── CarResource.php              ← "Otak" resource mobil
│   │       ├── Schemas/
│   │       │   └── CarForm.php              ← Definisi semua field form
│   │       ├── Tables/
│   │       │   └── CarsTable.php            ← Definisi kolom & filter tabel
│   │       └── RelationManagers/
│   │           └── ImagesRelationManager.php ← Tab "Images" di halaman edit
│   └── Widgets/
│       ├── StatsOverview.php                ← Kartu statistik di dashboard
│       ├── LatestCarsWidget.php             ← Tabel STNK mau habis
│       └── LatestContactsWidget.php         ← Tabel lead/kontak terbaru
└── Providers/
    └── Filament/
        └── AdminPanelProvider.php           ← Konfigurasi utama panel
```

---

## Konsep Utama: Resource

**Resource** = satu "modul" admin untuk satu tabel di database.

Di project ini ada satu resource: **CarResource** → untuk mengelola tabel `cars`.

Setiap resource punya halaman:
| Halaman | URL | Fungsi |
|---|---|---|
| List | `/admin/cars` | Tampilkan semua mobil |
| Create | `/admin/cars/create` | Tambah mobil baru |
| Edit | `/admin/cars/{id}/edit` | Edit mobil + upload foto |

---

## File 1: `AdminPanelProvider.php`

> **Lokasi:** `app/Providers/Filament/AdminPanelProvider.php`

Ini adalah **konfigurasi pusat** admin panel. Semua pengaturan global ada di sini.

```php
->id('admin')           // Panel ID → URL prefix /admin
->path('admin')         // URL: yoursite.com/admin
->login()               // Aktifkan halaman login bawaan Filament
->authMiddleware([
    Authenticate::class,
    IsAdmin::class,     // ← Hanya user dengan is_admin=true yang bisa masuk
])
->defaultThemeMode(ThemeMode::Dark)   // Default mode gelap
->viteTheme('resources/css/filament/admin/theme.css')  // Custom CSS tema
->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
```

**Yang penting dipahami:**
- `->login()` membuat halaman `/admin/login` secara otomatis
- `IsAdmin::class` adalah middleware custom yang mengecek `$user->is_admin === true`
- `discoverResources` = Filament akan otomatis temukan semua Resource di folder tersebut

---

## File 2: `CarResource.php`

> **Lokasi:** `app/Filament/Resources/Cars/CarResource.php`

Ini adalah "otak" dari semua halaman mobil. Filament membaca file ini untuk tahu:
- Model mana yang dipakai → `Car::class`
- Form mana yang dipakai → `CarForm::schema()`
- Tabel mana yang dipakai → `CarsTable::table()`
- Halaman apa saja yang ada → `ListCars`, `CreateCar`, `EditCar`

```php
class CarResource extends Resource
{
    protected static ?string $model = Car::class;    // Pakai model Car
    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function form(Form $form): Form
    {
        return CarForm::schema($form);  // Delegasi ke CarForm.php
    }

    public static function table(Table $table): Table
    {
        return CarsTable::table($table);  // Delegasi ke CarsTable.php
    }

    public static function getRelations(): array
    {
        return [
            ImagesRelationManager::class,  // Tab "Images" di halaman Edit
        ];
    }
}
```

---

## File 3: `CarForm.php`

> **Lokasi:** `app/Filament/Resources/Cars/Schemas/CarForm.php`

Form untuk halaman **Create** dan **Edit** mobil. Semua field input ada di sini.

### Cara kerja dasar:
```php
// Text field sederhana
TextInput::make('make')        // 'make' = nama kolom di database
    ->label('Merek')
    ->required()

// Dropdown/select
Select::make('transmission')
    ->options([
        'manual'    => 'Manual',
        'automatic' => 'Automatic',
    ])

// Upload file
FileUpload::make('primary_image_path')
    ->image()
    ->disk('public_root')      // Simpan ke folder public/
    ->directory('images/cars')
```

### Sections (Bagian Form)
Form dibagi jadi 6 bagian agar tidak berantakan:
1. **Informasi Dasar** — merek, model, tahun, harga
2. **Spesifikasi** — transmisi, bahan bakar, warna, dll
3. **Kondisi & Status** — odometer, pajak, plat nomor
4. **Foto Utama** — upload 1 foto utama
5. **Fitur Kendaraan** — daftar fitur (JSON)
6. **Pengaturan** — featured, available/terjual

---

## File 4: `CarsTable.php`

> **Lokasi:** `app/Filament/Resources/Cars/Tables/CarsTable.php`

Konfigurasi tabel di halaman **List Cars** (`/admin/cars`).

```php
// Kolom foto
ImageColumn::make('main_image')
    ->getStateUsing(fn($record) => $record->main_image)  // Ambil URL dari accessor

// Kolom teks
TextColumn::make('make')->searchable()->sortable()
TextColumn::make('price')->money('IDR')  // Format Rupiah otomatis

// Filter dropdown
SelectFilter::make('transmission')
    ->options(['manual' => 'Manual', 'automatic' => 'Automatic'])

// Tombol aksi di setiap baris
EditAction::make()
DeleteAction::make()
```

### Soft Delete di Tabel
Karena `Car` model pakai `SoftDeletes`, tombol **Delete** tidak benar-benar hapus data — hanya menandai `deleted_at`. Di tabel ada tab **Trash** untuk melihat mobil yang sudah dihapus, dan bisa dipulihkan.

---

## File 5: `ImagesRelationManager.php`

> **Lokasi:** `app/Filament/Resources/Cars/RelationManagers/ImagesRelationManager.php`

Ini adalah **tab "Images"** yang muncul di halaman Edit mobil. Mengelola relasi `Car hasMany CarImage`.

```
Edit Car Page
├── Tab: Form (data mobil utama)
└── Tab: Images (CRUD foto-foto tambahan)
          └── ImagesRelationManager mengelola ini
```

**Fitur penting:**
- Upload foto tambahan (max 13 foto total per mobil)
- Set foto mana yang jadi **foto utama** (`is_primary`)
- Atur urutan foto (`sort_order`)

**Logika max 13 foto:**
```php
CreateAction::make()
    ->before(function ($livewire, $action) {
        $count = $livewire->getOwnerRecord()->images()->count();
        if ($count >= 13) {
            Notification::make()->danger()->title('Maksimal 13 foto')->send();
            $action->halt();  // Batalkan aksi
        }
    })
```

---

## File 6: Widget Dashboard

> **Lokasi:** `app/Filament/Widgets/`

Widget = komponen yang tampil di halaman dashboard (`/admin`).

### `StatsOverview.php` — Kartu Statistik
```
┌─────────────────┐  ┌─────────────────┐
│  Stok Tersedia  │  │  Lead Minggu Ini │
│       42        │  │       7    ~~~~  │
└─────────────────┘  └─────────────────┘
┌─────────────────┐  ┌─────────────────┐
│  STNK Expiring  │  │  Featured Cars  │
│   🔴  3 mobil   │  │       5         │
└─────────────────┘  └─────────────────┘
```

Setiap stat relevan dengan bisnis (tidak ada "revenue" karena transaksi via WhatsApp):
- **Stok Tersedia** — mobil yang belum terjual
- **Lead Minggu Ini** — pesan masuk via form kontak
- **STNK Expiring** — mobil yang pajak/registrasinya mau habis dalam 30 hari
- **Featured Cars** — mobil yang ditampilkan di homepage

### `LatestContactsWidget.php` — Lead Terbaru
Tabel yang menampilkan 5 pesan kontak terbaru. Nomor HP bisa langsung di-klik untuk buka WhatsApp.

### `LatestCarsWidget.php` — STNK Mau Habis
Tabel mobil-mobil yang STNK-nya mau kadaluarsa, diurutkan dari yang paling mendesak.

---

## Alur Kerja: Bagaimana Semuanya Terhubung

```
Browser → /admin
    │
    ▼
AdminPanelProvider.php
    │  "Panel ini pakai middleware IsAdmin"
    │  "Temukan semua Resource & Widget"
    │
    ▼
CarResource.php
    │  "Model: Car"
    │  "Form: CarForm"
    │  "Table: CarsTable"
    │  "Relations: ImagesRelationManager"
    │
    ├── /admin/cars          → CarsTable.php (list)
    ├── /admin/cars/create   → CarForm.php (create)
    └── /admin/cars/{id}/edit
            ├── CarForm.php (edit data)
            └── ImagesRelationManager.php (edit foto)
```

---

## Namespace Penting (Filament 4)

Ini sering bikin bingung karena namanya mirip tapi lokasinya beda:

| Yang dipakai | Namespace yang benar |
|---|---|
| Form fields (`TextInput`, `Select`, dll) | `Filament\Forms\Components\*` |
| Table columns (`TextColumn`, `ImageColumn`) | `Filament\Tables\Columns\*` |
| Table filters (`SelectFilter`) | `Filament\Tables\Filters\*` |
| **Semua Actions** (Edit, Delete, Create, dll) | `Filament\Actions\*` ← satu namespace! |
| Notifications | `Filament\Notifications\Notification` |
| Stats widget | `Filament\Widgets\StatsOverviewWidget` |
| Table widget | `Filament\Widgets\TableWidget` |

> ⚠️ **Jebakan umum di Filament 4:** Di versi lama ada `Filament\Tables\Actions\EditAction`. Di Filament 4 sudah dihapus — semuanya pakai `Filament\Actions\EditAction`. Jika error "Class not found", cek namespace-nya dulu.

---

## Cara Menambah Field Baru ke Form

Misalnya kamu mau tambah field "Warna Interior":

**1. Tambah kolom ke database:**
```bash
php artisan make:migration add_interior_color_to_cars_table
```

**2. Di file migration:**
```php
$table->string('interior_color')->nullable();
```

**3. Jalankan migration:**
```bash
php artisan migrate
```

**4. Tambah ke `$fillable` di `Car` model:**
```php
protected $fillable = [
    // ... field lain ...
    'interior_color',
];
```

**5. Tambah ke `CarForm.php`:**
```php
TextInput::make('interior_color')
    ->label('Warna Interior')
    ->nullable(),
```

Selesai! Form akan otomatis tampilkan field baru.

---

## Cara Login ke Admin Panel

1. Buka `yoursite.com/admin` atau klik tombol **Login** di header
2. Email: `admin@rizkimobil.com`
3. Password: `password`

> Hanya user dengan `is_admin = true` di database yang bisa masuk.

---

## Custom Theme (Tampilan Dark)

File: `resources/css/filament/admin/theme.css`

Theme dibuat agar warnanya cocok dengan tampilan website publik yang gelap (`#0A0C10`).
Menggunakan variabel CSS `--color-gray-*` dari Tailwind 4 dengan format `oklch()`.

Setelah edit file CSS ini, harus build ulang:
```bash
npm run build
```

---

## Tips untuk Pemula

1. **Bingung error "Class not found"?** → Cek bagian Namespace di atas
2. **Foto tidak muncul?** → Pastikan `->disk('public_root')` dan `->visibility('public')` di FileUpload
3. **Perubahan tidak terlihat?** → Jalankan `npm run build` untuk compile ulang CSS
4. **Ingin lihat semua route admin?** → `php artisan route:list --path=admin`
5. **Database berubah?** → Selalu buat migration, jangan edit langsung di DB
6. **Mau reset data?** → `php artisan migrate:fresh --seed`
