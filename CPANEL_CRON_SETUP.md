# 📅 Setup Cron Job di cPanel UI - Step by Step

## 🎯 Tujuan
Setup scheduler Laravel agar berjalan otomatis setiap menit untuk menjalankan:
- Backup database harian
- Health check setiap jam
- Log cleanup mingguan
- Follow-up emails

---

## 📍 Langkah 1: Login ke cPanel

1. Buka browser
2. Masuk ke: `https://cpanel.yourdomain.com` atau `https://yourdomain.com:2083`
3. Login dengan username & password cPanel Anda

---

## 📍 Langkah 2: Cari Menu Cron Jobs

Di cPanel dashboard, cari menu **Cron Jobs**:

### Cara 1: Menggunakan Search
1. Di bagian atas cPanel, ada search box
2. Ketik: `cron`
3. Klik pada hasil "Cron Jobs"

### Cara 2: Navigasi Manual
1. Scroll ke bawah di cPanel dashboard
2. Cari section **Advanced**
3. Klik **Cron Jobs**

**Screenshot lokasi:**
```
┌─────────────────────────────────────────┐
│  cPanel Home                            │
├─────────────────────────────────────────┤
│  [Search box: cron]                     │
│                                         │
│  Advanced                               │
│  ├─ Cron Jobs          ← KLIK INI      │
│  ├─ Terminal                           │
│  └─ ...                                 │
└─────────────────────────────────────────┘
```

---

## 📍 Langkah 3: Tambah Cron Job Baru

Setelah masuk ke halaman Cron Jobs:

1. Klik tombol **"Add New Cron Job"** atau **"+ Add Cron Job"**

---

## 📍 Langkah 4: Isi Form Cron Job

Anda akan melihat form dengan field-field berikut:

### Field 1: Common Settings (Dropdown)
```
Common Settings: [Select a common setting ▼]
```
Pilih: **"Once per minute"** atau **"Every minute"**

Atau jika tidak ada, isi manual:
- **Minute:** `*`
- **Hour:** `*`
- **Day:** `*`
- **Month:** `*`
- **Weekday:** `*`

### Field 2: Command
Ini adalah command yang akan dijalankan. Isi dengan:

```bash
cd /home/username/northsumateratrip && php artisan schedule:run >> /dev/null 2>&1
```

**PENTING:** Ganti `username` dengan username cPanel Anda!

Cara tahu username:
- Lihat di URL cPanel: `https://cpanel.yourdomain.com:2083/cpsess.../home.html`
- Atau lihat di File Manager path: `/home/username/`
- Atau tanya hosting provider

### Contoh lengkap:
```bash
cd /home/northsum/northsumateratrip && php artisan schedule:run >> /dev/null 2>&1
```

---

## 📍 Langkah 5: Submit Form

1. Scroll ke bawah form
2. Klik tombol **"Add New Cron Job"** atau **"Save"**
3. Anda akan melihat pesan sukses: "Cron job added successfully"

---

## ✅ Verifikasi Cron Job

Setelah ditambahkan, Anda akan melihat cron job di list:

```
Current Cron Jobs
┌──────────────────────────────────────────────────────────┐
│ Command: cd /home/northsum/northsumateratrip && ...      │
│ Minute: *                                                │
│ Hour: *                                                  │
│ Day: *                                                   │
│ Month: *                                                 │
│ Weekday: *                                               │
│ [Edit] [Delete]                                          │
└──────────────────────────────────────────────────────────┘
```

---

## 🔍 Troubleshooting

### Masalah 1: Tidak bisa menemukan menu Cron Jobs
**Solusi:**
- Scroll ke bawah di cPanel dashboard
- Cari section "Advanced"
- Atau gunakan search box di atas

### Masalah 2: Error "Command not found"
**Solusi:**
- Pastikan path `/home/username/` benar
- Cek di File Manager lokasi folder project
- Ganti `username` dengan username yang benar

### Masalah 3: Cron job tidak berjalan
**Solusi:**
- Cek di cPanel: Cron Jobs → View Cron Job Log
- Lihat error message
- Pastikan path dan command benar
- Cek file permissions: `chmod -R 775 storage bootstrap/cache`

### Masalah 4: Tidak ada log cron job
**Solusi:**
- Cron job mungkin belum pernah dijalankan
- Tunggu 1-2 menit, refresh halaman
- Atau cek di: `/home/username/public_html/storage/logs/laravel.log`

---

## 📊 Apa yang Akan Berjalan Otomatis

Setelah cron job aktif, ini akan berjalan otomatis:

| Waktu | Task | Deskripsi |
|-------|------|-----------|
| 01:00 | backup:clean | Bersihkan backup lama |
| 02:00 | backup:run | Buat backup database & files |
| 03:00 | backup:monitor | Monitor kesehatan backup |
| 09:00 | trip:send-followup | Kirim email follow-up |
| Setiap jam | health:check | Cek kesehatan sistem |
| Minggu | logs:clear | Bersihkan log lama |

---

## 🧪 Test Cron Job Manual

Untuk test apakah cron job berfungsi, jalankan manual di SSH:

```bash
cd /home/username/northsumateratrip
php artisan schedule:run
```

Atau test backup:
```bash
php artisan backup:run
php artisan backup:list
```

---

## 📝 Contoh Lengkap Setup

### Scenario: Username = `northsum`, Domain = `northsumateratrip.com`

**Path project:** `/home/northsum/northsumateratrip`

**Cron command:**
```bash
cd /home/northsum/northsumateratrip && php artisan schedule:run >> /dev/null 2>&1
```

**Cron settings:**
- Minute: `*`
- Hour: `*`
- Day: `*`
- Month: `*`
- Weekday: `*`

---

## 🎯 Checklist

- [ ] Login ke cPanel
- [ ] Buka menu Cron Jobs (Advanced section)
- [ ] Klik "Add New Cron Job"
- [ ] Set frequency ke "Every minute" atau manual `*`
- [ ] Isi command dengan path yang benar
- [ ] Klik Save/Add
- [ ] Verifikasi cron job muncul di list
- [ ] Tunggu 1-2 menit
- [ ] Cek backup di `storage/app/backups/`
- [ ] Cek log di `storage/logs/laravel.log`

---

## 📞 Jika Masih Bingung

1. **Tanya hosting provider** untuk:
   - Username cPanel Anda
   - Path folder project yang benar
   - Apakah cron jobs diizinkan

2. **Cek di File Manager:**
   - Buka File Manager di cPanel
   - Lihat path folder project
   - Contoh: `/home/northsum/public_html/` atau `/home/northsum/northsumateratrip/`

3. **Gunakan SSH Terminal:**
   - Di cPanel, buka Terminal
   - Jalankan: `pwd` (untuk lihat current path)
   - Jalankan: `ls -la` (untuk lihat folder)

---

## 🎉 Selesai!

Setelah cron job aktif, sistem akan:
- ✅ Backup database otomatis setiap hari
- ✅ Monitor kesehatan sistem setiap jam
- ✅ Bersihkan log lama setiap minggu
- ✅ Kirim email follow-up otomatis

Semua berjalan tanpa perlu intervensi manual! 🚀
