#!/bin/bash

# Laravel Deployment Script for FrankenPHP/Railway
# Run this after deployment to ensure proper setup

echo "🚀 Starting Laravel deployment setup..."

# 1. Install dependencies with optimized autoloader
echo "📦 Installing Composer dependencies..."
composer install --optimize-autoloader --no-dev --no-interaction

# 2. Generate application key if not set
if [ -z "$APP_KEY" ]; then
    echo "🔑 Generating application key..."
    php artisan key:generate --force
fi

# 3. Clear all caches
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# 4. Create necessary directories
echo "📁 Creating necessary directories..."
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/cache
mkdir -p storage/logs
mkdir -p bootstrap/cache

# 5. Set permissions
echo "🔒 Setting permissions..."
chmod -R 775 storage bootstrap/cache

# 6. Run migrations
echo "🗄️  Running database migrations..."
php artisan migrate --force

# 7. Seed database if needed (optional - comment out if not needed)
# echo "🌱 Seeding database..."
# php artisan db:seed --force

echo "✅ Deployment setup complete!"
