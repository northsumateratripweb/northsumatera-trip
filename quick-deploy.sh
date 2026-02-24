#!/bin/bash

# Quick Deploy Script
# Run this after git pull

echo "🚀 Quick deploy starting..."

# Pull latest changes
echo "📥 Pulling latest changes..."
git pull origin main

# Install/update dependencies
echo "📦 Updating dependencies..."
composer install --optimize-autoloader --no-dev

# Clear cache
echo "🗑️ Clearing cache..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Run migrations
echo "🗄️ Running migrations..."
php artisan migrate --force

# Optimize
echo "⚡ Optimizing..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restart queue (if using supervisor)
# php artisan queue:restart

echo ""
echo "✅ Deploy complete!"
echo "🔍 Check for errors: tail -f storage/logs/laravel.log"
