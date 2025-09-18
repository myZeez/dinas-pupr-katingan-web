#!/bin/bash

# Deployment Script for Dinas PUPR Katingan Web Application
# Run this script after uploading files to hosting

echo "🚀 Starting deployment process..."

# Check if .env file exists
if [ ! -f .env ]; then
    echo "📋 Creating .env file from .env.production..."
    cp .env.production .env
    echo "⚠️  Please edit .env file with your hosting credentials!"
    echo "   - Database credentials"
    echo "   - Domain URL"
    echo "   - SMTP settings"
    exit 1
fi

# Install Composer dependencies
echo "📦 Installing Composer dependencies..."
composer install --optimize-autoloader --no-dev

# Generate application key if needed
echo "🔑 Checking application key..."
if grep -q "APP_KEY=$" .env; then
    echo "🔑 Generating application key..."
    php artisan key:generate
fi

# Clear and cache configurations
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

echo "💾 Caching configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage symbolic link
echo "🔗 Creating storage link..."
php artisan storage:link

# Set proper permissions
echo "🔒 Setting permissions..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chmod 644 .env

# Check database connection
echo "🗄️ Testing database connection..."
php artisan migrate:status

echo "✅ Deployment completed!"
echo ""
echo "📋 Manual steps remaining:"
echo "1. Import database/dinas-pupr-katingan.sql to your database"
echo "2. Update .env with your hosting details:"
echo "   - DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD"
echo "   - APP_URL with your domain"
echo "   - MAIL_* settings for email"
echo "3. Test the application"
echo ""
echo "🌐 Your application should be ready at your domain!"