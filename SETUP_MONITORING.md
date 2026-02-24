# 🚀 Setup Monitoring, Backup, Performance & Testing

## ✅ Yang Sudah Diinstall

1. **Spatie Laravel Backup** - Automated database & file backup
2. **Sentry** - Error tracking & monitoring
3. **Security Headers** - XSS, CSRF, Clickjacking protection
4. **Performance Monitoring** - Slow query & request tracking
5. **Automated Testing** - Security, Performance, Booking flow tests
6. **Health Check** - System monitoring
7. **Log Management** - Auto cleanup old logs

---

## 📋 Setup Checklist

### 1. Update .env File

Tambahkan konfigurasi berikut ke file `.env`:

```env
# Timezone
APP_TIMEZONE=Asia/Jakarta

# Sentry (sudah auto-added)
SENTRY_LARAVEL_DSN=https://6b2ef9b83e74461c043e1655cba2e336@o4510942430101504.ingest.de.sentry.io/4510942434361424
SENTRY_SEND_DEFAULT_PII=true
SENTRY_TRACES_SAMPLE_RATE=1.0

# Backup Configuration
BACKUP_DISK=local
BACKUP_NOTIFICATION_EMAIL=admin@northsumateratrip.com

# Health Check
HEALTH_CHECK_NOTIFY=true
```

### 2. Setup Backup Destination

Edit `config/backup.php` untuk menambahkan backup destination:

```php
'destination' => [
    'disks' => [
        'local',  // Backup ke storage/app/backups
        // 'google', // Uncomment jika mau backup ke Google Drive
        // 's3',     // Uncomment jika mau backup ke AWS S3
    ],
],
```

### 3. Setup Cron Job di cPanel

Login ke cPanel → Cron Jobs → Add New Cron Job:

```bash
# Run Laravel scheduler every minute
* * * * * cd /home/username/northsumateratrip && php artisan schedule:run >> /dev/null 2>&1
```

Scheduler akan otomatis menjalankan:
- Backup database (daily 02:00)
- Backup cleanup (daily 01:00)
- Backup monitoring (daily 03:00)
- Health check (hourly)
- Log cleanup (weekly)
- Follow-up emails (daily 09:00)

### 4. Test Backup System

```bash
# Manual backup test
php artisan backup:run

# Check backup status
php artisan backup:list

# Monitor backup health
php artisan backup:monitor
```

Backup akan disimpan di: `storage/app/backups/`

### 5. Test Sentry Integration

```bash
# Send test error to Sentry
php artisan sentry:test
```

Cek di dashboard Sentry: https://sentry.io/

### 6. Run Tests

```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature

# Run with coverage
php artisan test --coverage
```

### 7. Health Check

```bash
# Manual health check
php artisan health:check

# With notification
php artisan health:check --notify
```

---

## 🔧 Configuration Details

### A. Backup Configuration

File: `config/backup.php`

**What gets backed up:**
- Database (MySQL)
- Uploaded files (storage/app/public)
- Configuration files
- .env file (encrypted)

**What's excluded:**
- vendor/
- node_modules/
- cache files
- log files
- .git/

**Retention:**
- Keep all backups for 7 days
- Keep daily backups for 30 days
- Keep weekly backups for 90 days

### B. Sentry Configuration

File: `config/sentry.php`

**What gets tracked:**
- PHP errors & exceptions
- Slow database queries
- Failed jobs
- HTTP errors (4xx, 5xx)
- Performance metrics

**Environment:**
- Production: All errors tracked
- Staging: All errors tracked
- Local: Disabled (optional)

### C. Performance Monitoring

**Middleware:** `PerformanceMonitoring`

**Tracks:**
- Request execution time
- Memory usage
- Slow requests (> 1 second)

**Logs to:** `storage/logs/laravel.log`

### D. Security Headers

**Middleware:** `SecurityHeaders`

**Headers added:**
- X-Frame-Options: SAMEORIGIN
- X-Content-Type-Options: nosniff
- X-XSS-Protection: 1; mode=block
- Strict-Transport-Security (production only)
- Referrer-Policy: strict-origin-when-cross-origin

---

## 📊 Monitoring Dashboard

### Sentry Dashboard
- URL: https://sentry.io/
- View errors, performance, releases
- Set up alerts for critical errors

### Laravel Log Viewer (Optional)
```bash
composer require rap2hpoutre/laravel-log-viewer
```

Access at: `/logs` (protect with auth middleware)

### Database Monitoring
```bash
# Check slow queries in log
tail -f storage/logs/laravel.log | grep "Slow query"

# Check database size
php artisan db:show
```

---

## 🚨 Alerts & Notifications

### Email Notifications

Edit `config/backup.php`:

```php
'notifications' => [
    'mail' => [
        'to' => 'admin@northsumateratrip.com',
    ],
],
```

### WhatsApp Notifications

Health check sudah terintegrasi dengan WhatsAppService.

Tambahkan admin phone di `.env`:
```env
WHATSAPP_ADMIN_PHONE=6281234567890
```

### Sentry Alerts

Setup di Sentry Dashboard:
1. Project Settings → Alerts
2. Create Alert Rule
3. Set conditions (e.g., error rate > 10/hour)
4. Add notification channel (email, Slack, etc.)

---

## 📈 Performance Optimization

### 1. Cache Configuration

```bash
# Cache config, routes, views
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### 2. Database Optimization

```bash
# Optimize database
php artisan db:optimize

# Analyze slow queries
php artisan db:monitor
```

### 3. Asset Optimization

```bash
# Build for production
npm run build

# Optimize images
php artisan images:optimize
```

---

## 🧪 Testing Strategy

### Test Suites

1. **SecurityTest** - Security headers, CSRF, rate limiting, XSS
2. **PerformanceTest** - Page load time, query count, memory usage
3. **BookingFlowTest** - Tour booking, payment, reviews

### Running Tests

```bash
# All tests
php artisan test

# Specific test
php artisan test --filter=SecurityTest

# With coverage
php artisan test --coverage --min=80
```

### CI/CD Integration

Add to `.github/workflows/tests.yml`:

```yaml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: 8.2
      - name: Install Dependencies
        run: composer install
      - name: Run Tests
        run: php artisan test
```

---

## 🔍 Troubleshooting

### Backup Fails

```bash
# Check permissions
chmod -R 775 storage/app/backups

# Check disk space
df -h

# Check backup log
tail -f storage/logs/laravel.log | grep backup
```

### Sentry Not Tracking Errors

```bash
# Verify DSN
php artisan config:show sentry

# Test connection
php artisan sentry:test

# Check .env
cat .env | grep SENTRY
```

### Health Check Fails

```bash
# Run with verbose output
php artisan health:check -v

# Check individual components
php artisan db:show
php artisan cache:clear
```

### Tests Failing

```bash
# Clear cache before testing
php artisan config:clear
php artisan cache:clear

# Run with verbose output
php artisan test --verbose

# Check test database
cat .env.testing
```

---

## 📅 Maintenance Schedule

### Daily (Automated)
- ✓ Database backup (02:00)
- ✓ Backup cleanup (01:00)
- ✓ Backup monitoring (03:00)
- ✓ Follow-up emails (09:00)

### Hourly (Automated)
- ✓ Health check

### Weekly (Automated)
- ✓ Log cleanup

### Monthly (Manual)
- Review Sentry errors
- Check backup integrity
- Review performance metrics
- Update dependencies
- Security audit

---

## 🎯 Success Metrics

### Reliability
- ✓ 99.9% uptime
- ✓ Zero data loss (daily backups)
- ✓ < 1 hour recovery time

### Performance
- ✓ Page load < 2 seconds
- ✓ Database queries < 50 per page
- ✓ Memory usage < 50MB per request

### Security
- ✓ All security headers present
- ✓ CSRF protection enabled
- ✓ Rate limiting active
- ✓ No critical vulnerabilities

### Monitoring
- ✓ All errors tracked in Sentry
- ✓ Slow queries logged
- ✓ Health checks passing
- ✓ Backups successful

---

## 📞 Support

### Documentation
- Laravel Backup: https://spatie.be/docs/laravel-backup
- Sentry Laravel: https://docs.sentry.io/platforms/php/guides/laravel/
- Laravel Testing: https://laravel.com/docs/testing

### Commands Reference

```bash
# Backup
php artisan backup:run
php artisan backup:list
php artisan backup:monitor
php artisan backup:clean

# Health
php artisan health:check
php artisan health:check --notify

# Logs
php artisan logs:clear
php artisan logs:clear --days=7

# Testing
php artisan test
php artisan test --coverage

# Cache
php artisan cache:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## ✅ Post-Setup Verification

Run this checklist after setup:

```bash
# 1. Test backup
php artisan backup:run
php artisan backup:list

# 2. Test Sentry
php artisan sentry:test

# 3. Run tests
php artisan test

# 4. Health check
php artisan health:check

# 5. Check cron
crontab -l

# 6. Verify timezone
php artisan tinker
>>> now()

# 7. Check security headers
curl -I https://northsumateratrip.com
```

All checks should pass! ✅
