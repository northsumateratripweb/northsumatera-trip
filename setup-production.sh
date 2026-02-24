#!/bin/bash

# Production Setup Script for NorthSumateraTrip
# Run this after deploying to cPanel

echo "🚀 Starting production setup..."

# 1. Install dependencies
echo "📦 Installing dependencies..."
composer install --optimize-autoloader --no-dev

# 2. Set permissions
echo "🔐 Setting permissions..."
chmod -R 775 storage bootstrap/cache
find storage -type f -exec chmod 664 {} \;
find storage -type d -exec chmod 775 {} \;
find bootstrap/cache -type f -exec chmod 664 {} \;
find bootstrap/cache -type d -exec chmod 775 {} \;

# 3. Clear and cache
echo "🗑️ Clearing cache..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# 4. Run migrations
echo "🗄️ Running migrations..."
php artisan migrate --force

# 5. Seed translations
echo "🌐 Seeding translations..."
php artisan db:seed --class=TranslationSeeder --force

# 6. Optimize for production
echo "⚡ Optimizing..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 7. Create backup directory
echo "💾 Creating backup directory..."
mkdir -p storage/app/backups
chmod 775 storage/app/backups

# 8. Test backup
echo "🧪 Testing backup..."
php artisan backup:run

# 9. Health check
echo "🏥 Running health check..."
php artisan health:check

# 10. Create storage link
echo "🔗 Creating storage link..."
php artisan storage:link

echo ""
echo "✅ Production setup complete!"
echo ""
echo "📋 Next steps:"
echo "1. Setup cron job: * * * * * cd $(pwd) && php artisan schedule:run >> /dev/null 2>&1"
echo "2. Verify Sentry: php artisan sentry:test"
echo "3. Check website: curl -I https://northsumateratrip.com"
echo "4. Monitor logs: tail -f storage/logs/laravel.log"
echo ""
echo "📚 Documentation: See SETUP_MONITORING.md for details"
