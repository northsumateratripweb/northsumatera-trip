# Laporan Perbaikan Bug: Pengalihan Bahasa (Language Toggle)

## 1. Identifikasi Bug (Root Cause)
**Masalah:** Saat pengguna mengubah bahasa melalui switcher, tampilan aplikasi tetap dalam bahasa Inggris (default) meskipun session `locale` telah berubah.

**Root Cause:**
Kesalahan pada urutan middleware di file `bootstrap/app.php`. Middleware `SetLocale` dijalankan **sebelum** middleware `StartSession`. Karena `SetLocale` bergantung pada data session untuk menentukan bahasa yang dipilih user, middleware tersebut gagal mengambil nilai `locale` yang benar (karena session belum diinisialisasi) dan akhirnya selalu menggunakan bahasa default dari konfigurasi aplikasi.

## 2. Langkah Reproduksi
1. Buka halaman utama aplikasi.
2. Klik tombol "Language Switcher" di navigasi atas.
3. Pilih "Bahasa Indonesia".
4. Amati konten hero section (judul utama). Konten tetap dalam bahasa Inggris meskipun URL redirect berhasil kembali ke halaman utama.

## 3. Implementasi Perbaikan
- **Perbaikan Middleware Stack**: Mengubah urutan middleware di [app.php](file:///c:/Users/ridho/northsumatera-trip/bootstrap/app.php) sehingga `StartSession` dijalankan terlebih dahulu sebelum `SetLocale`.
- **Validasi Session**: Memastikan [SetLocale.php](file:///c:/Users/ridho/northsumatera-trip/app/Http/Middleware/SetLocale.php) mengambil locale dari session yang sudah aktif.
- **Pembersihan Cache Otomatis**: Menambahkan logic pada [Translation.php](file:///c:/Users/ridho/northsumatera-trip/app/Models/Translation.php) untuk menghapus cache terjemahan setiap kali ada perubahan data di admin panel, memastikan konten terbaru langsung muncul.

## 4. Hasil Pengujian (Integration Test)
Telah dilakukan pengujian otomatis menggunakan [TranslationSystemTest.php](file:///c:/Users/ridho/northsumatera-trip/tests/Feature/TranslationSystemTest.php) dengan hasil sebagai berikut:
- `it_can_translate_from_database`: **PASS** (Memastikan database terhubung ke sistem translasi).
- `it_can_switch_language_via_route`: **PASS** (Memastikan integrasi Session -> Middleware -> View bekerja 100%).
- `it_replaces_placeholders`: **PASS** (Memastikan variabel dinamis dalam teks tetap berfungsi).

## 5. Kesimpulan
Bug berhasil diatasi dengan menata ulang urutan eksekusi middleware. Sistem multibahasa sekarang dapat merespons perubahan session secara instan di seluruh komponen aplikasi.
