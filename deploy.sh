#!/bin/bash

# Laravel Deployment Script
# Usage: ./deploy.sh

echo "🚀 Starting deployment..."

# Pull latest changes
echo "📥 Pulling latest changes from git..."
git pull origin production

# Install/Update Composer dependencies
echo "📦 Installing Composer dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

# Install/Update NPM dependencies
echo "📦 Installing NPM dependencies..."
npm install --production

# Build assets if needed
echo "🔨 Building assets..."
npm run build

# Clear caches
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Optimize
echo "⚡ Optimizing..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations (optional, comment if not needed)
# echo "🗄️ Running migrations..."
# php artisan migrate --force

# Set permissions
echo "🔐 Setting permissions..."
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Restart services (uncomment if needed)
# php artisan queue:restart
# sudo systemctl reload php8.2-fpm
# sudo systemctl reload nginx

echo "✅ Deployment completed successfully!"
