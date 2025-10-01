<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password Admin - Dinas PUPR</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333333;
            margin: 0;
            padding: 0;
            background-color: #f4f6f9;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }

        .header img {
            width: 60px;
            height: 60px;
            margin-bottom: 20px;
            border-radius: 12px;
            background: white;
            padding: 10px;
        }

        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }

        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 16px;
        }

        .content {
            padding: 40px 30px;
        }

        .greeting {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .message {
            font-size: 16px;
            line-height: 1.8;
            color: #555555;
            margin-bottom: 30px;
        }

        .password-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px;
            border-radius: 12px;
            text-align: center;
            margin: 30px 0;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
        }

        .password-label {
            font-size: 14px;
            opacity: 0.9;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .password-value {
            font-size: 24px;
            font-weight: 700;
            font-family: 'Courier New', monospace;
            letter-spacing: 2px;
            background: rgba(255, 255, 255, 0.2);
            padding: 15px;
            border-radius: 8px;
            word-break: break-all;
        }

        .login-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            text-align: center;
            margin: 20px 0;
            transition: all 0.3s ease;
        }

        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .warning-box {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 20px;
            margin: 25px 0;
        }

        .warning-box h4 {
            color: #856404;
            margin: 0 0 10px 0;
            font-size: 16px;
        }

        .warning-box ul {
            color: #856404;
            margin: 0;
            padding-left: 20px;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }

        .footer p {
            margin: 0;
            color: #6c757d;
            font-size: 14px;
        }

        .footer .contact-info {
            margin-top: 15px;
            font-size: 13px;
        }

        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #ddd, transparent);
            margin: 30px 0;
        }

        @media (max-width: 600px) {
            .container {
                margin: 0 10px;
            }

            .header,
            .content,
            .footer {
                padding: 20px;
            }

            .password-value {
                font-size: 18px;
                letter-spacing: 1px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            @include('components.logo')
            <h1>Reset Password</h1>
            <p>{{ $profil->nama_instansi ?? 'Dinas Pekerjaan Umum dan Penataan Ruang' }}</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="greeting">
                Halo, {{ $name }}
            </div>

            <div class="message">
                Kami telah menerima permintaan reset password untuk akun administrator Anda di sistem Admin Dinas PUPR
                Kabupaten Katingan.
            </div>

            <div class="message">
                Password baru Anda telah berhasil dibuat. Silakan gunakan password berikut untuk login:
            </div>

            <!-- Password Box -->
            <div class="password-box">
                <div class="password-label">Password Baru Anda</div>
                <div class="password-value">{{ $newPassword }}</div>
            </div>

            <!-- Login Button -->
            <div style="text-align: center;">
                <a href="{{ $loginUrl }}" class="login-button">
                    🔑 Login Sekarang
                </a>
            </div>

            <!-- Warning -->
            <div class="warning-box">
                <h4>⚠️ Penting - Harap Dibaca</h4>
                <ul>
                    <li>Password ini telah di-generate secara otomatis dan aman</li>
                    <li>Segera ganti password setelah login pertama kali</li>
                    <li>Jangan bagikan password ini kepada siapapun</li>
                    <li>Password lama Anda sudah tidak dapat digunakan</li>
                    <li>Jika Anda tidak meminta reset password, segera hubungi administrator</li>
                </ul>
            </div>

            <div class="divider"></div>

            <div class="message">
                <strong>Detail Permintaan:</strong><br>
                📧 Email: {{ $email }}<br>
                🕒 Waktu: {{ $timestamp }}<br>
                🔗 Link Login: <a href="{{ $loginUrl }}">{{ $loginUrl }}</a>
            </div>

            <div class="message">
                Jika Anda mengalami kesulitan login atau ada pertanyaan, silakan hubungi administrator sistem.
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Dinas Pekerjaan Umum dan Penataan Ruang</strong></p>
            <p>Kabupaten Katingan, Kalimantan Tengah</p>

            <div class="contact-info">
                <p>📧 Email: info@dinaspupr-katingan.go.id</p>
                <p>📞 Telepon: (0536) 123456</p>
                <p>🌐 Website: www.dinaspupr-katingan.go.id</p>
            </div>

            <div style="margin-top: 20px; padding-top: 15px; border-top: 1px solid #ddd;">
                <p style="font-size: 12px; color: #999;">
                    Email ini dikirim secara otomatis oleh sistem. Mohon tidak membalas email ini.
                </p>
                <p style="font-size: 12px; color: #999;">
                    © {{ date('Y') }} Dinas PUPR Kabupaten Katingan. All rights reserved.
                </p>
            </div>
        </div>
    </div>
</body>

</html>
