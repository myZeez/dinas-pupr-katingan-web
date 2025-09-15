<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan Baru</title>
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
            background: linear-gradient(135deg, #2E8B57 0%, #1E5631 100%);
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
        .pengaduan-info {
            background-color: #f8f9fa;
            border-left: 4px solid #2E8B57;
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
            color: #2E8B57;
            display: inline-block;
            width: 120px;
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
            background-color: #2E8B57;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
            font-weight: bold;
            text-align: center;
        }
        .action-button:hover {
            background-color: #1E5631;
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
            background-color: #d1ecf1;
            border: 1px solid #bee5eb;
            color: #0c5460;
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
            <h1>🚨 Pengaduan Baru Diterima</h1>
            <p style="margin: 5px 0 0 0; opacity: 0.9;">Dinas PUPR Kabupaten Katingan</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="alert">
                <span class="alert-icon">ℹ️</span>
                <strong>Notifikasi:</strong> Sebuah pengaduan baru telah diterima melalui website dan memerlukan perhatian Anda.
            </div>

            <div class="pengaduan-info">
                <h3 style="margin-top: 0; color: #2E8B57;">📋 Detail Pengaduan</h3>
                
                <div class="info-row">
                    <span class="label">Nama:</span>
                    <span class="value">{{ $pengaduan->nama }}</span>
                </div>
                
                <div class="info-row">
                    <span class="label">Email:</span>
                    <span class="value">
                        <a href="mailto:{{ $pengaduan->email }}" style="color: #007bff; text-decoration: none;">
                            {{ $pengaduan->email }}
                        </a>
                    </span>
                </div>
                
                @if($pengaduan->telepon)
                <div class="info-row">
                    <span class="label">Telepon:</span>
                    <span class="value">
                        <a href="tel:{{ $pengaduan->telepon }}" style="color: #007bff; text-decoration: none;">
                            {{ $pengaduan->telepon }}
                        </a>
                    </span>
                </div>
                @endif
                
                <div class="info-row">
                    <span class="label">Subjek:</span>
                    <span class="value">{{ $pengaduan->subjek ?? 'Tidak ada subjek' }}</span>
                </div>
                
                <div class="info-row">
                    <span class="label">Status:</span>
                    <span class="value">
                        <span style="background-color: #ffc107; color: #212529; padding: 4px 8px; border-radius: 3px; font-size: 12px; font-weight: bold;">
                            {{ $pengaduan->status }}
                        </span>
                    </span>
                </div>
                
                <div class="info-row">
                    <span class="label">Waktu:</span>
                    <span class="value">{{ $pengaduan->created_at ? $pengaduan->created_at->format('d F Y, H:i') : now()->format('d F Y, H:i') }} WIB</span>
                </div>
            </div>

            <h4 style="color: #2E8B57; margin-bottom: 10px;">💬 Isi Pengaduan:</h4>
            <div class="message-content">
{{ $pengaduan->pesan }}
            </div>

            <!-- Action Button -->
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $adminUrl }}" class="action-button">
                    🔍 Lihat Detail & Tanggapi Pengaduan
                </a>
            </div>

            <div style="background-color: #e7f3ff; border: 1px solid #b6d7ff; border-radius: 5px; padding: 15px; margin: 20px 0;">
                <h4 style="margin: 0 0 10px 0; color: #0066cc;">📌 Tindakan Selanjutnya:</h4>
                <ul style="margin: 0; padding-left: 20px; color: #333;">
                    <li>Login ke panel admin untuk melihat detail lengkap</li>
                    <li>Ubah status pengaduan menjadi "Diproses"</li>
                    <li>Berikan tanggapan kepada pengadu</li>
                    <li>Follow up sesuai dengan kategori pengaduan</li>
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
