# Deployment Requirements Check

## PHP Requirements
- PHP >= 8.1
- BCMath PHP Extension
- Ctype PHP Extension  
- Fileinfo PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- GD PHP Extension (for image processing)
- CURL PHP Extension

## Server Requirements
- Apache/Nginx Web Server
- MySQL 5.7+ / MariaDB 10.3+
- SSL Certificate (recommended)
- Mod_rewrite enabled (Apache)

## Folder Structure Required
```
/public_html
├── public/ (DocumentRoot)
├── app/
├── bootstrap/
├── config/
├── database/
├── resources/
├── routes/
├── storage/ (writable)
├── vendor/
├── .env
├── artisan
└── composer.json
```

## Commands to Run After Upload
```bash
# 1. Install dependencies
composer install --optimize-autoloader --no-dev

# 2. Generate application key (if needed)
php artisan key:generate

# 3. Clear and cache configs
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 4. Create storage link
php artisan storage:link

# 5. Set permissions
chmod -R 755 storage
chmod -R 755 bootstrap/cache
```

## Database Setup
```bash
# 1. Create database in hosting panel
# 2. Import database/dinas-pupr-katingan.sql
# 3. Update .env with hosting database credentials
# 4. Run migrations (if needed)
php artisan migrate
```

## Security Checklist
- [ ] APP_ENV=production
- [ ] APP_DEBUG=false  
- [ ] Strong database passwords
- [ ] SSL certificate installed
- [ ] .env file permissions 644
- [ ] Remove composer.lock from public access
- [ ] Configure firewall if needed

## Testing Checklist
- [ ] Homepage loads
- [ ] Admin login works
- [ ] Database connection successful
- [ ] Email sending works
- [ ] CAPTCHA displays
- [ ] File uploads work
- [ ] Error pages display correctly
- [ ] SSL certificate valid