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
Untuk mengaktifkan auto-deploy ke cPanel, tambahkan secrets berikut di GitHub:
- `CPANEL_HOST` - Hostname cPanel Anda
- `CPANEL_USERNAME` - Username SSH cPanel
- `CPANEL_SSH_KEY` - Private SSH key untuk akses cPanel

Cara menambahkan secrets:
1. Buka repository di GitHub
2. Settings → Secrets and variables → Actions
3. Klik "New repository secret"
4. Tambahkan ketiga secrets di atas

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
