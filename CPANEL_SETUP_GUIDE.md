# Panduan Setup Laravel di cPanel

## ⚠️ PENTING - Langkah yang Harus Dilakukan di cPanel

### 1. Setup Database MySQL
Di cPanel, buat database MySQL:
1. Buka **MySQL Database Wizard** atau **MySQL Databases**
2. Buat database baru (contoh: `northsum_db`)
3. Buat user baru (contoh: `northsum_user`)
4. Berikan semua privileges ke user tersebut
5. Catat nama database, username, dan password

### 2. Update File .env
Edit file `.env` dan isi kredensial database:
```
DB_DATABASE=northsum_db
DB_USERNAME=northsum_user
DB_PASSWORD=password_anda
```

### 3. Set Permission Folder (SANGAT PENTING!)
Di File Manager cPanel atau via SSH, set permission:
```bash
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

Atau lebih aman:
```bash
find storage -type f -exec chmod 664 {} \;
find storage -type d -exec chmod 775 {} \;
find bootstrap/cache -type f -exec chmod 664 {} \;
find bootstrap/cache -type d -exec chmod 775 {} \;
```

### 4. Clear Cache Laravel
Via SSH atau Terminal di cPanel:
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### 5. Run Migration Database
```bash
php artisan migrate --force
```

### 6. Optimize untuk Production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 7. Setup Document Root
Di cPanel, pastikan Document Root mengarah ke folder `public`:
- Buka **Domains** atau **Addon Domains**
- Set Document Root ke: `/home/username/public_html/public`
- Atau jika di root: `/home/username/northsumateratrip/public`

## Troubleshooting Error 500

### Cek Error Log
1. Di cPanel, buka **Error Log**
2. Atau cek file: `storage/logs/laravel.log`

### Masalah Umum:

#### 1. Permission Error
```bash
chmod -R 775 storage bootstrap/cache
chown -R username:username storage bootstrap/cache
```

#### 2. .htaccess Tidak Bekerja
Pastikan mod_rewrite aktif di cPanel (biasanya sudah aktif)

#### 3. PHP Version
Pastikan menggunakan PHP 8.1 atau lebih tinggi:
- Di cPanel > **Select PHP Version**
- Pilih PHP 8.1 atau 8.2

#### 4. PHP Extensions Required
Pastikan extension ini aktif:
- BCMath
- Ctype
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- Tokenizer
- XML
- GD (untuk image processing)

### 5. Composer Dependencies
Jika ada masalah dengan dependencies:
```bash
composer install --optimize-autoloader --no-dev
```

## Struktur Folder di cPanel

```
/home/username/
├── public_html/              # Document root harus ke sini
│   └── (isi dari folder public Laravel)
├── northsumateratrip/        # Atau nama folder project
│   ├── app/
│   ├── bootstrap/
│   ├── config/
│   ├── database/
│   ├── public/              # ← Document root mengarah ke sini
│   ├── resources/
│   ├── routes/
│   ├── storage/             # ← Harus writable (775)
│   ├── vendor/
│   └── .env                 # ← File konfigurasi
```

## Setelah Setup Berhasil

1. Test website: https://northsumateratrip.com
2. Test admin panel: https://northsumateratrip.com/admin
3. Monitor error log secara berkala

## Kontak Support
Jika masih error, kirim screenshot dari:
1. Error message di browser
2. Error log dari cPanel
3. Isi file `storage/logs/laravel.log`
