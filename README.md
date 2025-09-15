# Dinas PUPR Katingan Web Application

Website resmi Dinas Pekerjaan Umum dan Penataan Ruang (PUPR) Kabupaten Katingan.

## Features

### 🏛️ Admin Panel
- Dashboard dengan analytics
- User management dengan role-based access
- Content management system
- News & article management
- Gallery & video management
- File download management
- Organization structure management
- CAPTCHA settings system
- Email configuration
- Activity logging system

### 🌐 Public Website
- News and articles
- Photo & video gallery
- Public services information
- Organization structure
- Contact forms
- Public complaint system (Pengaduan)
- File downloads
- Service tracking

### 🔒 Security Features
- Security headers middleware
- Brute force protection
- Request sanitization
- Security monitoring
- CSRF protection
- SQL injection protection

### 📧 Email System
- SMTP configuration
- Email notifications
- Contact form emails
- Complaint notifications
- Password reset emails

### 🛡️ CAPTCHA System
- Google reCAPTCHA integration
- Configurable CAPTCHA settings
- Anti-spam protection

## Tech Stack

- **Framework**: Laravel 11
- **Frontend**: Bootstrap 5, Blade Templates
- **Database**: MySQL
- **Email**: SMTP (Gmail supported)
- **Security**: CAPTCHA, Security middlewares
- **API**: RESTful API with Swagger documentation

## Installation

1. Clone repository
```bash
git clone https://github.com/budiaat/dinas-pupr-katingan-web.git
cd dinas-pupr-katingan-web
```

2. Install dependencies
```bash
composer install
npm install
```

3. Environment setup
```bash
cp .env.example .env
php artisan key:generate
```

4. Database setup
```bash
php artisan migrate
php artisan db:seed
```

5. Storage link
```bash
php artisan storage:link
```

6. Serve application
```bash
php artisan serve
```

## Configuration

### Database
Edit `.env` file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dinas-pupr-katingan
DB_USERNAME=root
DB_PASSWORD=
```

### Email (Gmail)
```
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-gmail@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
```

### CAPTCHA
```
NOCAPTCHA_SITEKEY=your-site-key
NOCAPTCHA_SECRET=your-secret-key
CAPTCHA_REQUIRED=true
```

## Default Admin Account

After seeding:
- **Email**: admin@pupr-katingan.go.id
- **Password**: admin123

**⚠️ Change default password immediately after first login!**

## API Documentation

API documentation available at: `/api/documentation`

## Contributing

1. Fork the repository
2. Create feature branch (`git checkout -b feature/feature-name`)
3. Commit changes (`git commit -am 'Add some feature'`)
4. Push to branch (`git push origin feature/feature-name`)
5. Create Pull Request

## License

This project is developed for Dinas PUPR Kabupaten Katingan.

## Support

For support, contact: admin@pupr-katingan.go.id

---

**Dinas Pekerjaan Umum dan Penataan Ruang**  
**Kabupaten Katingan**  
**Kalimantan Tengah**
