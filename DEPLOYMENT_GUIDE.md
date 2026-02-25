# 🚀 Deployment Guide - North Sumatera Trip

## ✅ GitHub Deployment - COMPLETED

Code telah berhasil di-push ke GitHub repository:
- Repository: https://github.com/northsumateratripweb/northsumatera-trip
- Branch: main
- Latest Commit: Travel Website Redesign Complete

### GitHub Actions CI/CD

Workflow otomatis sudah dikonfigurasi untuk:
1. **Run Tests** - Menjalankan semua test suite setiap push/PR
2. **Auto Deploy** - Deploy otomatis ke cPanel setelah test berhasil (hanya untuk push ke main)

**Setup GitHub Secrets untuk Auto Deploy:**

### Cara Mendapatkan Informasi untuk GitHub Secrets:

#### 1. CPANEL_HOST (Hostname cPanel)
**Dari mana mendapatkan:**
- Login ke cPanel Anda
- Lihat di bagian kanan atas atau email welcome dari hosting provider
- Biasanya berbentuk: `yourdomain.com` atau `server123.hostingprovider.com`
- Atau cek di email setup hosting Anda

**Contoh:**
```
northsumateratrip.com
atau
server.hostingprovider.com
```

#### 2. CPANEL_USERNAME (Username SSH)
**Dari mana mendapatkan:**
- Sama dengan username cPanel Anda
- Biasanya diberikan saat pertama kali setup hosting
- Cek di email welcome dari hosting provider
- Atau tanyakan ke support hosting

**Contoh:**
```
northsum
atau
cpanelusername
```

#### 3. CPANEL_SSH_KEY (Private SSH Key)
**Cara membuat SSH Key:**

**A. Generate SSH Key di komputer lokal:**

**Windows (PowerShell):**
```powershell
# 1. Buka PowerShell
# 2. Generate SSH key
ssh-keygen -t rsa -b 4096 -C "your_email@example.com"

# 3. Tekan Enter untuk lokasi default (C:\Users\YourName\.ssh\id_rsa)
# 4. Tekan Enter 2x untuk skip passphrase (untuk automation)
# 5. Key akan tersimpan di: C:\Users\YourName\.ssh\id_rsa
```

**Mac/Linux (Terminal):**
```bash
# 1. Buka Terminal
# 2. Generate SSH key
ssh-keygen -t rsa -b 4096 -C "your_email@example.com"

# 3. Tekan Enter untuk lokasi default (~/.ssh/id_rsa)
# 4. Tekan Enter 2x untuk skip passphrase
# 5. Key akan tersimpan di: ~/.ssh/id_rsa
```

**B. Copy Private Key:**

**Windows:**
```powershell
# Buka file dengan notepad
notepad C:\Users\YourName\.ssh\id_rsa

# Atau copy ke clipboard
Get-Content C:\Users\YourName\.ssh\id_rsa | clip
```

**Mac/Linux:**
```bash
# Tampilkan isi private key
cat ~/.ssh/id_rsa

# Atau copy ke clipboard (Mac)
pbcopy < ~/.ssh/id_rsa

# Atau copy ke clipboard (Linux)
xclip -sel clip < ~/.ssh/id_rsa
```

**C. Upload Public Key ke cPanel:**

1. Copy public key:
   ```bash
   # Windows
   Get-Content C:\Users\YourName\.ssh\id_rsa.pub
   
   # Mac/Linux
   cat ~/.ssh/id_rsa.pub
   ```

2. Login ke cPanel
3. Cari "SSH Access" atau "Manage SSH Keys"
4. Klik "Import Key" atau "Manage"
5. Paste public key (file .pub) ke form
6. Authorize the key

**PENTING:** 
- Yang di-upload ke cPanel adalah **PUBLIC KEY** (id_rsa.pub)
- Yang disimpan di GitHub Secrets adalah **PRIVATE KEY** (id_rsa)
- JANGAN share private key ke siapapun!

### Cara Menambahkan Secrets ke GitHub:

1. **Buka Repository di GitHub:**
   ```
   https://github.com/northsumateratripweb/northsumatera-trip
   ```

2. **Masuk ke Settings:**
   - Klik tab "Settings" di repository
   - Scroll ke menu kiri, klik "Secrets and variables"
   - Klik "Actions"

3. **Tambahkan Secret Pertama (CPANEL_HOST):**
   - Klik tombol "New repository secret"
   - Name: `CPANEL_HOST`
   - Secret: Paste hostname cPanel Anda (contoh: `northsumateratrip.com`)
   - Klik "Add secret"

4. **Tambahkan Secret Kedua (CPANEL_USERNAME):**
   - Klik "New repository secret" lagi
   - Name: `CPANEL_USERNAME`
   - Secret: Paste username cPanel Anda
   - Klik "Add secret"

5. **Tambahkan Secret Ketiga (CPANEL_SSH_KEY):**
   - Klik "New repository secret" lagi
   - Name: `CPANEL_SSH_KEY`
   - Secret: Paste SELURUH isi private key (termasuk `-----BEGIN RSA PRIVATE KEY-----` dan `-----END RSA PRIVATE KEY-----`)
   - Klik "Add secret"

### Verifikasi Setup:

Setelah menambahkan ketiga secrets:
1. Buka tab "Actions" di repository GitHub
2. Lihat workflow "Deploy to cPanel"
3. Jika ada error, cek logs untuk troubleshooting

### Troubleshooting SSH Connection:

Jika auto-deploy gagal dengan error SSH:

**1. Test SSH connection manual:**
```bash
ssh username@hostname
```

**2. Pastikan SSH enabled di cPanel:**
- Login cPanel → SSH Access
- Pastikan "Manage SSH Keys" tersedia
- Jika tidak ada, hubungi hosting support untuk enable SSH

**3. Pastikan public key sudah authorized:**
- cPanel → SSH Access → Manage SSH Keys
- Pastikan key Anda ada di "Authorized Keys"

**4. Pastikan path deployment benar:**
- Di workflow file, path adalah `~/northsumateratrip`
- Sesuaikan dengan path actual di server Anda

## 📦 cPanel Deployment Steps

### 1. Login ke cPanel
- URL: https://your-cpanel-url.com:2083
- Username: [your-cpanel-username]
- Password: [your-cpanel-password]

### 2. Pull Latest Code dari GitHub

**Option A: Via Terminal (Recommended)**
```bash
cd /home/[username]/public_html
git pull origin main
```

**Option B: Via File Manager**
1. Buka File Manager di cPanel
2. Navigate ke public_html
3. Upload files manually (not recommended for large projects)

### 3. Install Dependencies

```bash
# Install Composer dependencies
composer install --optimize-autoloader --no-dev

# Install NPM dependencies (if not already built)
npm install

# Build assets for production
npm run build
```

### 4. Set Permissions

```bash
# Set proper permissions
chmod -R 755 storage bootstrap/cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Set ownership (replace username with your cPanel username)
chown -R username:username storage
chown -R username:username bootstrap/cache
```

### 5. Environment Configuration

```bash
# Copy .env.example if .env doesn't exist
cp .env.example .env

# Edit .env file with production settings
nano .env
```

**Important .env settings:**
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

### 6. Generate Application Key

```bash
php artisan key:generate
```

### 7. Run Migrations

```bash
# Run database migrations
php artisan migrate --force

# Seed database (if needed)
php artisan db:seed --force
```

### 8. Optimize Application

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Cache for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize autoloader
composer dump-autoload --optimize
```

### 9. Setup Symbolic Link for Storage

```bash
php artisan storage:link
```

### 10. Configure .htaccess (if needed)

Ensure your `.htaccess` in public folder has:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

### 11. Setup Cron Jobs (Optional)

Add to cPanel Cron Jobs:
```bash
* * * * * cd /home/[username]/public_html && php artisan schedule:run >> /dev/null 2>&1
```

## 🔍 Post-Deployment Checklist

- [ ] Website loads correctly
- [ ] All images display properly
- [ ] Navigation works (desktop & mobile)
- [ ] Hero section displays fullscreen
- [ ] Trust section shows ratings and testimonials
- [ ] Tour packages grid displays correctly
- [ ] Forms submit successfully
- [ ] Database connections work
- [ ] SSL certificate is active
- [ ] Performance is optimized
- [ ] Accessibility features work

## 🐛 Troubleshooting

### Issue: 500 Internal Server Error
**Solution:**
```bash
# Check error logs
tail -f storage/logs/laravel.log

# Fix permissions
chmod -R 755 storage bootstrap/cache
```

### Issue: Assets not loading
**Solution:**
```bash
# Rebuild assets
npm run build

# Clear cache
php artisan cache:clear
```

### Issue: Database connection error
**Solution:**
- Check .env database credentials
- Verify database exists in cPanel MySQL
- Check database user has proper permissions

### Issue: White screen / blank page
**Solution:**
```bash
# Enable debug temporarily
# Edit .env: APP_DEBUG=true
# Check storage/logs/laravel.log
# Remember to set APP_DEBUG=false after fixing
```

## 📊 Performance Optimization

### Enable OPcache (if available)
Add to php.ini:
```ini
opcache.enable=1
opcache.memory_consumption=128
opcache.max_accelerated_files=10000
opcache.revalidate_freq=60
```

### Enable Gzip Compression
Add to .htaccess:
```apache
<IfModule mod_deflate.c>
    AddOutputFilterByType DEFLATE text/html text/plain text/xml text/css text/javascript application/javascript
</IfModule>
```

### Browser Caching
Add to .htaccess:
```apache
<IfModule mod_expires.c>
    ExpiresActive On
    ExpiresByType image/jpg "access plus 1 year"
    ExpiresByType image/jpeg "access plus 1 year"
    ExpiresByType image/gif "access plus 1 year"
    ExpiresByType image/png "access plus 1 year"
    ExpiresByType text/css "access plus 1 month"
    ExpiresByType application/javascript "access plus 1 month"
</IfModule>
```

## 🔐 Security Checklist

- [ ] APP_DEBUG=false in production
- [ ] Strong APP_KEY generated
- [ ] Database credentials secure
- [ ] .env file not publicly accessible
- [ ] SSL certificate installed
- [ ] HTTPS redirect enabled
- [ ] File permissions set correctly (755/644)
- [ ] Remove unnecessary files (.git, tests, etc.)

## 📞 Support

Jika ada masalah saat deployment:
1. Check error logs: `storage/logs/laravel.log`
2. Check cPanel error logs
3. Contact hosting support if needed

## 🎉 Deployment Complete!

Setelah semua langkah selesai, website Anda sudah live dengan:
- ✅ Modern responsive design
- ✅ Optimized performance
- ✅ Full accessibility support
- ✅ Mobile-first approach
- ✅ SEO optimized
- ✅ Core Web Vitals monitoring

Visit: https://your-domain.com
