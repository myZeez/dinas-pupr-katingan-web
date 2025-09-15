<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Documentation - Dinas PUPR</title>
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/swagger-ui-dist@4.15.5/swagger-ui.css" />
    <style>
        body {
            margin: 0;
            background: #f5f7fa;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .swagger-ui .topbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .swagger-ui .topbar .download-url-wrapper {
            display: none;
        }

        .swagger-ui .info hgroup.main .title {
            color: #667eea;
            font-size: 36px;
        }

        .loading-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .spinner {
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top: 3px solid white;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .error-container {
            text-align: center;
            padding: 50px 20px;
            background: #fff;
            border-radius: 8px;
            margin: 20px auto;
            max-width: 600px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .retry-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }

        #swagger-ui {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }
    </style>
</head>

<body>
    <div id="loading-container" class="loading-container">
        <div class="spinner"></div>
        <div style="margin-top: 20px; font-size: 18px;">Memuat dokumentasi API...</div>
    </div>

    <div id="swagger-ui"></div>

    <div id="error-container" class="error-container" style="display: none;">
        <h2 style="color: #e74c3c;">Gagal memuat dokumentasi</h2>
        <p>Terjadi masalah saat memuat dokumentasi API. Silakan coba lagi.</p>
        <button class="retry-button" onclick="location.reload()">Coba Lagi</button>
    </div>

    <script src="https://unpkg.com/swagger-ui-dist@4.15.5/swagger-ui-bundle.js"></script>
    <script src="https://unpkg.com/swagger-ui-dist@4.15.5/swagger-ui-standalone-preset.js"></script>
    <script>
        window.onload = function() {
            try {
                const ui = SwaggerUIBundle({
                    url: '{{ url('/api/documentation.json') }}',
                    dom_id: '#swagger-ui',
                    deepLinking: true,
                    presets: [
                        SwaggerUIBundle.presets.apis,
                        SwaggerUIStandalonePreset
                    ],
                    plugins: [
                        SwaggerUIBundle.plugins.DownloadUrl
                    ],
                    validatorUrl: null,
                    tryItOutEnabled: true,
                    onComplete: function() {
                        console.log('Swagger UI loaded successfully');
                        document.getElementById('loading-container').style.display = 'none';
                    },
                    onFailure: function(error) {
                        console.error('Error loading Swagger UI:', error);
                        document.getElementById('loading-container').style.display = 'none';
                        document.getElementById('error-container').style.display = 'block';
                    }
                });
            } catch (error) {
                console.error('Error initializing Swagger UI:', error);
                document.getElementById('loading-container').style.display = 'none';
                document.getElementById('error-container').style.display = 'block';
            }
        }

        // Fallback timeout
        setTimeout(function() {
            if (document.getElementById('loading-container').style.display !== 'none') {
                console.log('Timeout: Showing error');
                document.getElementById('loading-container').style.display = 'none';
                document.getElementById('error-container').style.display = 'block';
            }
        }, 15000);
    </script>
</body>

</html>
