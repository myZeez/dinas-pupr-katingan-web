<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password Super Admin</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #667eea;
            padding-bottom: 30px;
            margin-bottom: 30px;
        }
        .title {
            color: #667eea;
            font-size: 28px;
            font-weight: bold;
            margin: 0;
        }
        .subtitle {
            color: #666;
            font-size: 16px;
            margin: 5px 0 0 0;
        }
        .content {
            margin-bottom: 30px;
        }
        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }
        .password-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            margin: 25px 0;
        }
        .password-label {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 10px;
        }
        .password-text {
            font-size: 24px;
            font-weight: bold;
            letter-spacing: 2px;
            font-family: 'Courier New', monospace;
            background: rgba(255,255,255,0.2);
            padding: 15px;
            border-radius: 5px;
        }
        .login-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: bold;
            margin: 20px 0;
            transition: all 0.3s ease;
        }
        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            color: white;
            text-decoration: none;
        }
        .instructions {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin: 25px 0;
            border-left: 4px solid #667eea;
        }
        .instructions h4 {
            color: #667eea;
            margin-top: 0;
        }
        .instructions ul {
            margin: 10px 0;
            padding-left: 20px;
        }
        .instructions li {
            margin: 8px 0;
            color: #666;
        }
        .footer {
            border-top: 1px solid #eee;
            padding-top: 20px;
            text-align: center;
            color: #888;
            font-size: 14px;
        }
        .security-notice {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
        .security-notice h4 {
            color: #856404;
            margin-top: 0;
        }
        .contact-info {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1 class="title">DINAS PUPR</h1>
            <p class="subtitle">Kabupaten Katingan</p>
        </div>

        <!-- Content -->
        <div class="content">
            <p class="greeting">Halo <strong>{{ $admin_name }}</strong>,</p>
            
            <p>Kami telah menerima permintaan reset password untuk akun Super Admin Anda. Password baru telah dibuat dan siap digunakan.</p>
            
            <!-- Password Box -->
            <div class="password-box">
                <div class="password-label">Password Baru Super Admin:</div>
                <div class="password-text">{{ $new_password }}</div>
            </div>
            
            <!-- Login Button -->
            <div style="text-align: center;">
                <a href="{{ $login_url }}" class="login-button">
                    🔐 Login Sekarang
                </a>
            </div>
            
            <!-- Instructions -->
            <div class="instructions">
                <h4>📋 Petunjuk Login Super Admin:</h4>
                <ul>
                    <li><strong>Email:</strong> {{ $admin_email }}</li>
                    <li><strong>Password:</strong> Gunakan password baru di atas</li>
                    <li>Klik tombol "Login Sekarang" atau salin password secara manual</li>
                    <li>Setelah login, Anda dapat mengganti password sesuai keinginan</li>
                    <li>Gunakan privilege Super Admin dengan bijak</li>
                </ul>
            </div>
            
            <!-- Security Notice -->
            <div class="security-notice">
                <h4>⚠️ Keamanan Super Admin:</h4>
                <ul>
                    <li>Password lama Anda sudah tidak berlaku</li>
                    <li><strong>JANGAN bagikan password ini kepada siapa pun</strong></li>
                    <li>Super Admin memiliki akses penuh ke sistem</li>
                    <li>Disarankan mengganti password setelah login pertama</li>
                    <li>Jika Anda tidak meminta reset password, segera hubungi tim IT</li>
                </ul>
            </div>
            
            <!-- Contact Info -->
            <div class="contact-info">
                <h4>📞 Butuh Bantuan?</h4>
                <p>Jika mengalami kesulitan login atau memiliki pertanyaan keamanan:</p>
                <ul>
                    <li><strong>Email Support:</strong> {{ $support_email }}</li>
                    <li><strong>Tim IT Dinas PUPR</strong></li>
                    <li><strong>Admin Sistem</strong></li>
                </ul>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Email ini dikirim secara otomatis oleh sistem {{ $app_name }}.</p>
            <p><strong>Super Admin</strong> - Akses Tertinggi Sistem</p>
            <hr style="border: none; border-top: 1px solid #eee; margin: 20px 0;">
            <p style="font-size: 12px; color: #999;">
                © {{ date('Y') }} Dinas Pekerjaan Umum dan Penataan Ruang Kabupaten Katingan.<br>
                <strong>KONFIDENSIAL:</strong> Email ini hanya untuk Super Admin yang berwenang.
            </p>
        </div>
    </div>
</body>
</html>
