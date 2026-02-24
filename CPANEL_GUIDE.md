# Panduan Hosting Laravel ke cPanel (Realtime Auto-Deploy)

Untuk membuat website Anda terupdate otomatis dari lokal ke cPanel, ikuti langkah-langkah berikut:

## 1. Siapkan Repository GitHub
*   Pastikan semua kode Anda sudah di-upload ke GitHub.
*   Gunakan perintah berikut di terminal lokal Anda (jika belum):
    ```bash
    git init
    git add .
    git commit -m "Siap hosting ke cPanel"
    git branch -M main
    git remote add origin https://github.com/USERNAME_ANDA/REPOS_ANDA.git
    git push -u origin main
    ```

## 2. Set Up Database di cPanel
*   Masuk ke cPanel ➔ **MySQL Database Wizard**.
*   Buat database, user, dan berikan semua izin (privileges).
*   Catat nama database, username, dan password-nya.

## 3. Set Up Link Penyimpanan (Symlink)
Karena di cPanel kita menggunakan `.htaccess` untuk mengarahkan ke folder `public`, jalankan perintah ini sekali saja di File Manager cPanel (Terminal) atau lewat SSH:
```bash
php artisan storage:link
```

## 4. Konfigurasi GitHub Secrets
Agar GitHub bisa mengirim file ke cPanel, Anda perlu menambahkan "Secrets" di GitHub:
1.  Buka repository Anda di GitHub.
2.  Pilih **Settings** ➔ **Secrets and variables** ➔ **Actions**.
3.  Klik **New repository secret** dan tambahkan 3 data ini:
    *   `FTP_SERVER`: Alamat FTP Anda (biasanya `ftp.domainanda.com` atau alamat IP hosting).
    *   `FTP_USERNAME`: Username FTP cPanel Anda.
    *   `FTP_PASSWORD`: Password FTP cPanel Anda.

## 5. File .htaccess
Saya sudah membuatkan file `.htaccess` di root folder agar Laravel bisa berjalan langsung di folder utama cPanel (seperti `public_html`) tanpa harus mengetik `/public` di URL.

## 6. Selesai!
Sekarang, setiap kali Anda mengetik `git push` di komputer lokal, GitHub akan otomatis:
1.  Menjalankan tes kode.
2.  Menginstal dependencies (Composer & Node).
3.  Membangun aset (Vite/Build).
4.  Mengirimkan perubahan terbaru langsung ke cPanel Anda secara **Realtime**.
