# Web Error Audit - Dinas PUPR Katingan

## 📋 **Status Overview**
- **Environment Local**: ✅ Normal - Aplikasi berjalan tanpa error di localhost
- **Environment Hosting**: ❌ Error - Error muncul saat di-deploy ke hosting
- **Repository**: https://github.com/myZeez/dinas-pupr-katingan-web

---

## 🔧 **1. CONFIG CHECK**

### Environment Configuration Audit

#### File yang Perlu Diperiksa:
- `.env.production` ✅ (Ada di repository)
- Konfigurasi hosting environment
- Laravel configuration files

#### Checklist Konfigurasi:

##### **Database Configuration**
```bash
# Local (.env)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dinas-pupr-katingan
DB_USERNAME=root
DB_PASSWORD=

# Hosting (.env.production) - SESUAIKAN:
DB_CONNECTION=mysql
DB_HOST=localhost / IP_DATABASE_SERVER
DB_PORT=3306
DB_DATABASE=nama_database_hosting
DB_USERNAME=username_database_hosting
DB_PASSWORD=password_database_hosting
```

##### **Application Configuration**
```bash
# SESUAIKAN untuk hosting:
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domain-anda.com
```

##### **Email Configuration**
```bash
# SESUAIKAN SMTP hosting:
MAIL_HOST=smtp.hostingprovider.com
MAIL_USERNAME=email@domain-anda.com
MAIL_PASSWORD=password_email_hosting
```

##### **CAPTCHA Configuration**
```bash
# Pastikan keys masih valid:
NOCAPTCHA_SITEKEY=6LffJ8QrAAAAANWw0KNSZYvPaK3GiD6fx2i7iGxM
NOCAPTCHA_SECRET=6LffJ8QrAAAAANpsBaGKLRlye4AKv5gtEQSI0SwH
```

---

## 📦 **2. DEPENDENCIES CHECK**

### PHP Requirements
```bash
# Minimum requirements:
PHP >= 8.1
Composer
Extensions: BCMath, Ctype, Fileinfo, JSON, Mbstring, OpenSSL, PDO, Tokenizer, XML
```

### Composer Dependencies
```bash
# Verifikasi di hosting:
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Node.js Dependencies (jika ada)
```bash
npm install
npm run build
```

---

## 🗄️ **3. DATABASE CHECK**

### Database Setup
1. **Import Database**: `database/dinas-pupr-katingan.sql`
2. **Run Migrations**: `php artisan migrate`
3. **Check Tables**: Pastikan semua tabel ter-create

### Database Schema Verification
```sql
-- Tabel yang harus ada:
SHOW TABLES;

-- Tabel kritis:
- users
- captcha_settings
- settings
- pengaduan
- berita
- galeri_news
- struktur
```

---

## 📁 **4. PERMISSION CHECK**

### Folder Permissions (chmod 755/775)
```bash
/storage
/storage/app
/storage/framework
/storage/framework/cache
/storage/framework/sessions
/storage/framework/views
/storage/logs
/bootstrap/cache
/public
```

### File Permissions (chmod 644)
```bash
.env
composer.json
artisan
```

### Storage Link
```bash
php artisan storage:link
```

---

## 🚨 **5. COMMON HOSTING ERRORS & SOLUTIONS**

### Error 500 - Internal Server Error
**Penyebab:**
- `.env` file tidak ada atau salah konfigurasi
- Database connection gagal
- Permission folder salah
- PHP version tidak kompatibel

**Solusi:**
```bash
1. Copy .env.production ke .env dan sesuaikan
2. Cek database credentials
3. Set permission folders
4. php artisan config:clear
```

### Error 404 - Page Not Found
**Penyebab:**
- .htaccess tidak ter-upload
- Mod_rewrite tidak aktif
- Document root salah

**Solusi:**
```bash
1. Upload .htaccess ke public folder
2. Set document root ke /public
3. Aktifkan mod_rewrite
```

### Database Connection Error
**Penyebab:**
- Database credentials salah
- Database tidak exist
- Database server down

**Solusi:**
```bash
1. Verifikasi DB credentials di hosting panel
2. Import database/dinas-pupr-katingan.sql
3. Test connection
```

### SMTP/Email Error
**Penyebab:**
- SMTP credentials salah
- Port blocked
- SSL/TLS configuration

**Solusi:**
```bash
1. Gunakan SMTP hosting provider
2. Cek port 587/465
3. Set encryption TLS/SSL
```

---

## 📝 **DEPLOYMENT CHECKLIST**

### Pre-Deployment
- [ ] Upload semua files ke hosting
- [ ] Set document root ke `/public`
- [ ] Copy `.env.production` ke `.env`
- [ ] Edit `.env` dengan kredensial hosting
- [ ] Import database SQL
- [ ] Set folder permissions

### Post-Deployment
- [ ] `composer install --optimize-autoloader --no-dev`
- [ ] `php artisan key:generate`
- [ ] `php artisan config:cache`
- [ ] `php artisan route:cache`
- [ ] `php artisan view:cache`
- [ ] `php artisan storage:link`
- [ ] Test aplikasi

### Verifikasi
- [ ] Homepage loading
- [ ] Admin login works
- [ ] Database connection
- [ ] Email sending
- [ ] File upload/download
- [ ] CAPTCHA working

---

## 🔍 **ERROR LOG ANALYSIS**

### Cara Cek Error Logs:
```bash
# Di hosting cPanel/panel:
1. Buka Error Logs
2. Atau cek storage/logs/laravel.log
3. Atau php error logs
```

### Common Error Patterns:
1. **Class not found** → `composer dump-autoload`
2. **Permission denied** → Set folder permissions
3. **Connection refused** → Check database credentials
4. **Memory limit** → Increase PHP memory_limit
5. **Execution time** → Increase max_execution_time

---

## 📞 **NEXT STEPS**

**Untuk troubleshooting lebih lanjut, silakan berikan:**

1. **Server Information:**
   - OS server (Linux/Windows/cPanel)
   - PHP version
   - Database type & version
   - Web server (Apache/Nginx)

2. **Error Logs:**
   - Copy paste error message lengkap
   - Screenshot error page
   - Laravel log dari storage/logs/

3. **Hosting Details:**
   - Hosting provider
   - Control panel type
   - Server specifications

**Contact:** admin@pupr-katingan.go.id untuk support deployment.