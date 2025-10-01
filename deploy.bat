@echo off
REM Deployment Script for Windows Hosting - Dinas PUPR Katingan Web Application

echo 🚀 Starting deployment process...

REM Check if .env file exists
if not exist .env (
    echo 📋 Creating .env file from .env.production...
    copy .env.production .env
    echo ⚠️  Please edit .env file with your hosting credentials!
    echo    - Database credentials
    echo    - Domain URL
    echo    - SMTP settings
    pause
    exit /b 1
)

REM Install Composer dependencies
echo 📦 Installing Composer dependencies...
composer install --optimize-autoloader --no-dev

REM Generate application key if needed
echo 🔑 Generating application key...
php artisan key:generate

REM Clear and cache configurations
echo 🧹 Clearing caches...
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

echo 💾 Caching configurations...
php artisan config:cache
php artisan route:cache
php artisan view:cache

REM Create storage symbolic link
echo 🔗 Creating storage link...
php artisan storage:link

REM Check database connection
echo 🗄️ Testing database connection...
php artisan migrate:status

echo ✅ Deployment completed!
echo.
echo 📋 Manual steps remaining:
echo 1. Import database/dinas-pupr-katingan.sql to your database
echo 2. Update .env with your hosting details:
echo    - DB_HOST, DB_DATABASE, DB_USERNAME, DB_PASSWORD
echo    - APP_URL with your domain
echo    - MAIL_* settings for email
echo 3. Test the application
echo.
echo 🌐 Your application should be ready at your domain!
pause
