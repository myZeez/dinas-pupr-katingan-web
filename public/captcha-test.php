<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CAPTCHA Test</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input,
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            background: #007bff;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background: #0056b3;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>🛡️ CAPTCHA Test Page</h1>

        <?php
        $message = '';
        $messageType = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Load .env for configuration
            $config = [];
            if (file_exists('.env')) {
                $lines = file('.env');
                foreach ($lines as $line) {
                    if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
                        list($key, $value) = explode('=', trim($line), 2);
                        $config[trim($key)] = trim($value);
                    }
                }
            }

            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $message_content = $_POST['message'] ?? '';
            $captchaResponse = $_POST['g-recaptcha-response'] ?? '';

            // Validate CAPTCHA
            if (empty($captchaResponse)) {
                $message = '❌ Please complete the CAPTCHA verification!';
                $messageType = 'danger';
            } else {
                // Verify CAPTCHA with Google
                $secretKey = $config['NOCAPTCHA_SECRET'] ?? '';
                $verifyURL = 'https://www.google.com/recaptcha/api/siteverify';
                $response = file_get_contents($verifyURL . '?secret=' . $secretKey . '&response=' . $captchaResponse);
                $responseData = json_decode($response, true);

                if ($responseData['success']) {
                    $message = '✅ CAPTCHA verified successfully! Form submitted.';
                    $messageType = 'success';
                } else {
                    $message = '❌ CAPTCHA verification failed. Please try again.';
                    $messageType = 'danger';
                }
            }
        }
        ?>

        <?php if ($message): ?>
            <div class="alert alert-<?= $messageType ?>">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>

            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="4" required><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
            </div>

            <div class="form-group">
                <div class="g-recaptcha" data-sitekey="6LcYJcQrAAAAAEWwlQW6Zb8GjXHF4HjnkZb4v2MA"></div>
            </div>

            <button type="submit">Submit Form</button>
        </form>
    </div>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>

</html>