# ⚡ Quick Guide - Isi Form Cron Job di cPanel

## 📍 Anda Sudah di Halaman yang Benar!

Halaman "Cron Jobs" sudah terbuka. Sekarang ikuti langkah ini:

---

## 🎯 Langkah 1: Isi Field "Minute"

**Field:** Minute (kotak input di sebelah kiri)

**Isi dengan:** `*`

```
Minute: [*]
```

---

## 🎯 Langkah 2: Isi Field "Hour"

**Field:** Hour (kotak input di sebelah kiri)

**Isi dengan:** `*`

```
Hour: [*]
```

---

## 🎯 Langkah 3: Isi Field "Day"

**Field:** Day (kotak input di sebelah kiri)

**Isi dengan:** `*`

```
Day: [*]
```

---

## 🎯 Langkah 4: Isi Field "Month"

**Field:** Month (kotak input di sebelah kiri)

**Isi dengan:** `*`

```
Month: [*]
```

---

## 🎯 Langkah 5: Isi Field "Weekday"

**Field:** Weekday (kotak input di sebelah kiri)

**Isi dengan:** `*`

```
Weekday: [*]
```

---

## 🎯 Langkah 6: Isi Field "Command" (PALING PENTING!)

**Field:** Command (kotak input besar di bawah)

**Isi dengan:**
```bash
cd /home/northsum/northsumateratrip && php artisan schedule:run >> /dev/null 2>&1
```

**CATATAN:** 
- Jika username Anda BUKAN `northsum`, ganti dengan username yang benar
- Cek di File Manager untuk lihat username Anda
- Path harus sesuai dengan lokasi folder project Anda

---

## 📋 Contoh Lengkap Pengisian Form

```
Minute:     [*]
Hour:       [*]
Day:        [*]
Month:      [*]
Weekday:    [*]
Command:    [cd /home/northsum/northsumateratrip && php artisan schedule:run >> /dev/null 2>&1]
```

---

## ✅ Langkah 7: Submit

1. Scroll ke bawah
2. Klik tombol biru **"Add New Cron Job"**
3. Tunggu sampai muncul pesan sukses

---

## 🔍 Cara Tahu Username Anda

Jika tidak tahu username, ikuti salah satu cara ini:

### Cara 1: Lihat di cPanel
1. Di cPanel, klik **"File Manager"**
2. Lihat path di atas: `/home/USERNAME/`
3. USERNAME itu adalah username Anda

### Cara 2: Lihat di URL cPanel
1. Lihat URL browser: `https://cpanel.yourdomain.com:2083/cpsess.../home.html`
2. Atau lihat di bagian atas cPanel ada nama user

### Cara 3: Tanya Hosting Provider
- Email atau chat dengan support hosting
- Minta tahu username cPanel

---

## 🎯 Contoh Berbeda Sesuai Username

| Username | Command |
|----------|---------|
| northsum | `cd /home/northsum/northsumateratrip && php artisan schedule:run >> /dev/null 2>&1` |
| user123 | `cd /home/user123/northsumateratrip && php artisan schedule:run >> /dev/null 2>&1` |
| admin | `cd /home/admin/northsumateratrip && php artisan schedule:run >> /dev/null 2>&1` |

---

## ⚠️ PENTING: Path Folder Project

Pastikan path folder project benar:

### Kemungkinan 1: Folder di root
```
/home/username/northsumateratrip/
```
Command:
```bash
cd /home/username/northsumateratrip && php artisan schedule:run >> /dev/null 2>&1
```

### Kemungkinan 2: Folder di public_html
```
/home/username/public_html/
```
Command:
```bash
cd /home/username/public_html && php artisan schedule:run >> /dev/null 2>&1
```

### Kemungkinan 3: Folder di subdomain
```
/home/username/public_html/northsumateratrip/
```
Command:
```bash
cd /home/username/public_html/northsumateratrip && php artisan schedule:run >> /dev/null 2>&1
```

---

## 🧪 Cara Cek Path yang Benar

1. Buka **File Manager** di cPanel
2. Lihat di mana folder `northsumateratrip` berada
3. Lihat path lengkapnya
4. Gunakan path itu di command

---

## ✅ Checklist Sebelum Submit

- [ ] Minute: `*`
- [ ] Hour: `*`
- [ ] Day: `*`
- [ ] Month: `*`
- [ ] Weekday: `*`
- [ ] Command: Sudah diisi dengan path yang benar
- [ ] Username di command sudah benar
- [ ] Path folder sudah benar

---

## 🎉 Setelah Submit

1. Klik **"Add New Cron Job"**
2. Tunggu pesan sukses
3. Cron job akan muncul di list di atas
4. Sistem akan otomatis berjalan setiap menit

---

## 🚨 Jika Ada Error

### Error: "Command not found"
- Cek username di command
- Cek path folder di command
- Pastikan folder `northsumateratrip` ada di path tersebut

### Error: "Permission denied"
- Cek permission folder: `chmod -R 775 storage bootstrap/cache`
- Atau hubungi hosting provider

### Cron job tidak berjalan
- Tunggu 1-2 menit
- Cek di cPanel: Cron Jobs → View Cron Job Log
- Lihat error message di log

---

## 📞 Butuh Bantuan?

Jika masih bingung:
1. Buka File Manager di cPanel
2. Lihat path folder project
3. Ganti username di command dengan username Anda
4. Submit form

Atau hubungi saya dengan screenshot path folder di File Manager!
