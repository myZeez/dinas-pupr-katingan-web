<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak | DINAS PUPR Katingan</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
        }
        
        .error-container {
            text-align: center;
            background: white;
            padding: 3rem 2rem;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            max-width: 500px;
            width: 90%;
        }
        
        .error-code {
            font-size: 6rem;
            font-weight: bold;
            color: #e74c3c;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        
        .error-title {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #2c3e50;
        }
        
        .error-message {
            font-size: 1.1rem;
            color: #7f8c8d;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        
        .actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            display: inline-block;
        }
        
        .btn-primary {
            background: #3498db;
            color: white;
        }
        
        .btn-primary:hover {
            background: #2980b9;
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background: #95a5a6;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #7f8c8d;
            transform: translateY(-2px);
        }
        
        .logo {
            width: 80px;
            height: 80px;
            margin: 0 auto 2rem;
            background: #3498db;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: white;
            font-weight: bold;
        }
        
        @media (max-width: 480px) {
            .error-code {
                font-size: 4rem;
            }
            
            .error-title {
                font-size: 1.5rem;
            }
            
            .actions {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="logo">
            🔒
        </div>
        
        <div class="error-code">403</div>
        
        <h1 class="error-title">Akses Ditolak</h1>
        
        <p class="error-message">
            {{ $message ?? 'Anda tidak memiliki izin untuk mengakses halaman ini. Silakan hubungi administrator jika Anda merasa ini adalah kesalahan.' }}
        </p>
        
        <div class="actions">
            <a href="{{ url('/') }}" class="btn btn-primary">
                🏠 Halaman Utama
            </a>
            <a href="javascript:history.back()" class="btn btn-secondary">
                ← Kembali
            </a>
        </div>
    </div>
    
    <script>
        // Auto redirect ke home setelah 10 detik jika tidak ada interaksi
        let redirectTimer = setTimeout(function() {
            if (confirm('Redirect otomatis ke halaman utama dalam 5 detik. Lanjutkan?')) {
                window.location.href = '{{ url('/') }}';
            }
        }, 10000);
        
        // Cancel timer jika user berinteraksi
        document.addEventListener('click', function() {
            clearTimeout(redirectTimer);
        });
        
        document.addEventListener('keypress', function() {
            clearTimeout(redirectTimer);
        });
    </script>
</body>
</html>
