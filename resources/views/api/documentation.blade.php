<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation - Dinas PUPR</title>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/swagger-ui-dist@5.0.0/swagger-ui.css" />
    <style>
        body {
            margin: 0;
            background: #fafafa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .swagger-ui .topbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 15px 0;
        }

        .swagger-ui .topbar .download-url-wrapper {
            display: none;
        }

        .swagger-ui .info .title {
            color: #333;
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .swagger-ui .info .description {
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 20px;
        }

        .header-custom {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }

        .header-custom h1 {
            margin: 0;
            font-size: 2rem;
        }

        .header-custom p {
            margin: 10px 0 0 0;
            opacity: 0.9;
        }

        #swagger-ui {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px 20px 20px;
        }

        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 400px;
            flex-direction: column;
        }

        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #667eea;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 2s linear infinite;
            margin-bottom: 20px;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .error {
            text-align: center;
            padding: 40px;
            color: #e74c3c;
            background: #fff;
            border: 2px solid #e74c3c;
            border-radius: 8px;
            margin: 20px;
        }

        .retry-btn {
            background: #667eea;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 15px;
        }
    </style>
</head>

<body>
    <div class="header-custom">
        <h1>API Documentation</h1>
        <p>Dinas Pekerjaan Umum dan Penataan Ruang</p>
    </div>

    <div id="loading" class="loading">
        <div class="spinner"></div>
        <div>Memuat dokumentasi API...</div>
    </div>

    <div id="error" class="error" style="display: none;">
        <h3>Gagal Memuat Dokumentasi</h3>
        <p>Terjadi kesalahan saat memuat dokumentasi API.</p>
        <button class="retry-btn" onclick="location.reload()">Coba Lagi</button>
    </div>

    <div id="swagger-ui"></div>

    <script src="https://unpkg.com/swagger-ui-dist@5.0.0/swagger-ui-bundle.js"></script>
    <script src="https://unpkg.com/swagger-ui-dist@5.0.0/swagger-ui-standalone-preset.js"></script>

    <script>
        window.onload = function() {
            // Add timeout for loading
            const loadingTimeout = setTimeout(() => {
                document.getElementById('loading').style.display = 'none';
                document.getElementById('error').style.display = 'block';
            }, 10000);

            try {
                const ui = SwaggerUIBundle({
                    // Load static file directly from public to avoid any framework output pollution
                    url: '{{ asset('api-docs.json') }}?v={{ now()->timestamp }}',
                    dom_id: '#swagger-ui',
                    deepLinking: true,
                    presets: [
                        SwaggerUIBundle.presets.apis,
                        SwaggerUIStandalonePreset
                    ],
                    plugins: [
                        SwaggerUIBundle.plugins.DownloadUrl
                    ],
                    layout: "StandaloneLayout",
                    validatorUrl: null,
                    tryItOutEnabled: true,
                    supportedSubmitMethods: ['get', 'put', 'post', 'delete', 'options', 'head', 'patch'],
                    onComplete: function() {
                        console.log('Swagger UI loaded successfully');
                        clearTimeout(loadingTimeout);
                        document.getElementById('loading').style.display = 'none';
                    },
                    onFailure: function(error) {
                        console.error('Swagger UI error:', error);
                        clearTimeout(loadingTimeout);
                        document.getElementById('loading').style.display = 'none';
                        document.getElementById('error').style.display = 'block';
                    }
                });
            } catch (error) {
                console.error('Error initializing Swagger UI:', error);
                clearTimeout(loadingTimeout);
                document.getElementById('loading').style.display = 'none';
                document.getElementById('error').style.display = 'block';
            }
        }
    </script>
</body>

</html>
