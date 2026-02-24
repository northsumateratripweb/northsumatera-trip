# Dokumentasi Sistem Multibahasa (Multilingual System)

Sistem ini menggunakan pendekatan berbasis database untuk menyimpan terjemahan, dengan sistem caching untuk performa optimal dan fallback ke file bahasa standar Laravel.

## Struktur File Terkait
- **`app/Helpers/TranslationHelper.php`**: Berisi logika utama untuk mengambil terjemahan dari database/cache.
- **`app/Helpers/functions.php`**: Mendefinisikan fungsi helper global `__t()` untuk memudahkan penggunaan di view/controller.
- **`app/Http/Middleware/SetLocale.php`**: Middleware untuk mengatur locale aplikasi berdasarkan session user.
- **`app/Models/Translation.php`**: Model Eloquent untuk tabel `translations`, dilengkapi dengan logic pembersihan cache otomatis saat data berubah.
- **`app/Filament/Resources/TranslationResource.php`**: Antarmuka admin (Filament) untuk mengelola data terjemahan.
- **`database/migrations/xxxx_create_translations_table.php`**: Struktur tabel database untuk menyimpan terjemahan.

## Kode Bahasa yang Didukung
Saat ini sistem mendukung 3 bahasa utama:
1.  **`id`**: Bahasa Indonesia (Default)
2.  **`en`**: English
3.  **`ms`**: Bahasa Malaysia

## Cara Menggunakan di Frontend
Gunakan fungsi helper `__t($key, $replace = [], $locale = null)`:

```blade
<!-- Contoh penggunaan di Blade -->
<h1>{{ __t('home_hero_title') }}</h1>

<!-- Dengan placeholder -->
<p>{{ __t('welcome_message', ['name' => 'User']) }}</p>
```

## Cara Menambahkan Bahasa Baru
Untuk menambahkan bahasa baru (misalnya: Jepang/`ja`), ikuti langkah-langkah berikut:

1.  **Update Database Migration**:
    Tambahkan kolom `ja_value` pada tabel `translations`.
    ```php
    $table->text('ja_value')->nullable();
    ```
2.  **Update Model**:
    Tambahkan `ja_value` ke dalam property `$fillable` di `app/Models/Translation.php` dan update fungsi `booted()` untuk membersihkan cache `translations_ja`.
3.  **Update Filament Resource**:
    Tambahkan field input untuk `ja_value` di `app/Filament/Resources/TranslationResource.php`.
4.  **Update Middleware & Helper**:
    Tambahkan `ja` ke dalam array validasi di `SetLocale.php`, `TranslationHelper.php`, dan `web.php` (route switcher).
5.  **Update UI Switcher**:
    Tambahkan opsi bahasa Jepang pada dropdown switcher di `resources/views/welcome.blade.php`.

## Fitur Unggulan
- **Caching**: Terjemahan disimpan di cache secara permanen (`Cache::rememberForever`) dan hanya diperbarui saat ada perubahan data di admin panel.
- **Robust Error Handling**: Jika database bermasalah, sistem akan mencatat log error dan beralih ke fallback tanpa menghentikan aplikasi.
- **Fallback Hierarchy**: 
    1. Database (Locale terpilih)
    2. Laravel Standard Language Files (`lang/*.php`)
    3. Key itu sendiri (jika tidak ditemukan di mana pun)
- **Logging**: Jika `APP_DEBUG=true`, sistem akan mencatat key yang hilang di database ke dalam file log Laravel untuk memudahkan audit konten.
