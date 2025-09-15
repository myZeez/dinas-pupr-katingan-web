<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Kontak Baru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: white;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 30px;
        }
        .kontak-info {
            background-color: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
        }
        .info-row {
            margin-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 10px;
        }
        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
        .label {
            font-weight: bold;
            color: #007bff;
            display: inline-block;
            width: 100px;
        }
        .value {
            color: #495057;
        }
        .message-content {
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 15px;
            margin-top: 10px;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        .action-button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 5px;
            font-weight: bold;
            text-align: center;
        }
        .action-button:hover {
            background-color: #0056b3;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #6c757d;
            font-size: 14px;
            border-top: 1px solid #dee2e6;
        }
        .alert {
            background-color: #cce7ff;
            border: 1px solid #99d6ff;
            color: #004085;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        .alert-icon {
            font-size: 18px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>💌 Pesan Kontak Baru</h1>
            <p style="margin: 5px 0 0 0; opacity: 0.9;">Dinas PUPR Kabupaten Katingan</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="alert">
                <span class="alert-icon">📧</span>
                <strong>Notifikasi:</strong> Sebuah pesan baru telah diterima melalui formulir kontak website.
            </div>

            <div class="kontak-info">
                <h3 style="margin-top: 0; color: #007bff;">📝 Detail Pesan</h3>
                
                <div class="info-row">
                    <span class="label">Nama:</span>
                    <span class="value">{{ $kontakData['nama'] }}</span>
                </div>
                
                <div class="info-row">
                    <span class="label">Email:</span>
                    <span class="value">
                        <a href="mailto:{{ $kontakData['email'] }}" style="color: #007bff; text-decoration: none;">
                            {{ $kontakData['email'] }}
                        </a>
                    </span>
                </div>
                
                <div class="info-row">
                    <span class="label">Subjek:</span>
                    <span class="value">{{ $kontakData['subjek'] }}</span>
                </div>
                
                <div class="info-row">
                    <span class="label">Waktu:</span>
                    <span class="value">{{ now()->format('d F Y, H:i') }} WIB</span>
                </div>
            </div>

            <h4 style="color: #007bff; margin-bottom: 10px;">💬 Isi Pesan:</h4>
            <div class="message-content">
{{ $kontakData['pesan'] }}
            </div>

            <!-- Action Buttons -->
            <div style="text-align: center; margin: 30px 0;">
                <a href="mailto:{{ $kontakData['email'] }}?subject=Re: {{ $kontakData['subjek'] }}" class="action-button">
                    📧 Balas Email
                </a>
                <a href="mailto:{{ $kontakData['email'] }}?subject=Re: {{ $kontakData['subjek'] }}&body=Terima kasih atas pesan Anda." class="action-button">
                    ✏️ Balas dengan Template
                </a>
            </div>

            <div style="background-color: #e7f3ff; border: 1px solid #b6d7ff; border-radius: 5px; padding: 15px; margin: 20px 0;">
                <h4 style="margin: 0 0 10px 0; color: #0066cc;">📌 Tindakan Selanjutnya:</h4>
                <ul style="margin: 0; padding-left: 20px; color: #333;">
                    <li>Baca pesan dengan teliti</li>
                    <li>Berikan tanggapan dalam 1-2 hari kerja</li>
                    <li>Jika diperlukan, lakukan koordinasi internal</li>
                    <li>Pastikan memberikan informasi yang akurat dan membantu</li>
                </ul>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Dinas Pekerjaan Umum dan Penataan Ruang (PUPR)</strong><br>
            Kabupaten Katingan, Kalimantan Tengah</p>
            <p style="margin: 10px 0 0 0; font-size: 12px;">
                Email ini dikirim secara otomatis oleh sistem. Mohon jangan membalas email ini.
            </p>
        </div>
    </div>
</body>
</html>
