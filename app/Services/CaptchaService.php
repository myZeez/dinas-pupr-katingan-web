<?php

namespace App\Services;

use Anhskohbo\NoCaptcha\Facades\NoCaptcha;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CaptchaService
{
    /**
     * Verify reCAPTCHA response
     */
    public function verify($captchaResponse, $request = null)
    {
        try {
            // Skip verification if CAPTCHA is disabled
            if (!$this->isRequired()) {
                Log::info('CAPTCHA verification skipped (disabled)');
                return true;
            }

            // Check if captcha response is provided
            if (empty($captchaResponse)) {
                Log::warning('CAPTCHA verification failed: No response provided');
                return false;
            }

            // Get secret from database or env
            $secret = $this->getSecretKey();
            if (empty($secret)) {
                Log::error('CAPTCHA verification failed: No secret key configured');
                return false;
            }

            // Manual verification with Google API
            $response = Http::post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secret,
                'response' => $captchaResponse,
                'remoteip' => $request ? $request->ip() : null,
            ]);

            $result = $response->json();

            if ($result && isset($result['success']) && $result['success']) {
                Log::info('CAPTCHA verification successful', [
                    'ip' => $request ? $request->ip() : 'unknown',
                    'user_agent' => $request ? $request->userAgent() : 'unknown'
                ]);
                return true;
            } else {
                Log::warning('CAPTCHA verification failed: Invalid response', [
                    'ip' => $request ? $request->ip() : 'unknown',
                    'response_length' => strlen($captchaResponse)
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('CAPTCHA verification error', [
                'error' => $e->getMessage(),
                'ip' => $request ? $request->ip() : 'unknown',
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            // In case of error, allow through to prevent complete blocking
            // but log the incident for monitoring
            return true;
        }
    }

    /**
     * Check if CAPTCHA is required
     */
    public function isRequired()
    {
        // Try database first, fallback to env
        if (class_exists('\App\Models\CaptchaSetting')) {
            return \App\Models\CaptchaSetting::getValue('captcha_required', env('CAPTCHA_REQUIRED', true));
        }
        return env('CAPTCHA_REQUIRED', true);
    }

    /**
     * Get CAPTCHA site key
     */
    public function getSiteKey()
    {
        // Try database first, fallback to env
        if (class_exists('\App\Models\CaptchaSetting')) {
            return \App\Models\CaptchaSetting::getValue('nocaptcha_sitekey', env('NOCAPTCHA_SITEKEY'));
        }
        return env('NOCAPTCHA_SITEKEY');
    }

    /**
     * Get CAPTCHA secret key
     */
    public function getSecretKey()
    {
        // Try database first, fallback to env
        if (class_exists('\App\Models\CaptchaSetting')) {
            return \App\Models\CaptchaSetting::getValue('nocaptcha_secret', env('NOCAPTCHA_SECRET'));
        }
        return env('NOCAPTCHA_SECRET');
    }

    /**
     * Get CAPTCHA version (v2 or v3)
     */
    public function getVersion()
    {
        // Try database first, fallback to env
        if (class_exists('\App\Models\CaptchaSetting')) {
            return \App\Models\CaptchaSetting::getValue('nocaptcha_version', env('NOCAPTCHA_VERSION', '2'));
        }
        return env('NOCAPTCHA_VERSION', '2');
    }

    /**
     * Check if using reCAPTCHA Enterprise keys
     */
    public function isEnterprise(): bool
    {
        // Try database first, fallback to env
        if (class_exists('\App\Models\CaptchaSetting')) {
            return (bool) \App\Models\CaptchaSetting::getValue('nocaptcha_enterprise', env('NOCAPTCHA_ENTERPRISE', false));
        }
        return (bool) env('NOCAPTCHA_ENTERPRISE', false);
    }

    /**
     * Generate CAPTCHA HTML
     */
    public function html($attributes = [])
    {
        if (!$this->isRequired()) {
            return '';
        }
        // If enterprise mode, render container manually (package only supports classic api.js)
        if ($this->isEnterprise()) {
            $attrs = '';
            foreach ($attributes as $k => $v) {
                $attrs .= ' ' . htmlspecialchars($k) . '="' . htmlspecialchars($v) . '"';
            }
            return '<div id="recaptcha-container" class="g-recaptcha" data-sitekey="' . e($this->getSiteKey()) . '"' . $attrs . '></div>';
        }
        return NoCaptcha::display($attributes);
    }

    /**
     * Generate CAPTCHA script
     */
    public function script()
    {
        if (!$this->isRequired()) {
            return '';
        }
        if ($this->isEnterprise()) {
            $siteKey = $this->getSiteKey();
            // Use enterprise.js; for checkbox we still allow automatic rendering via class but ensure readiness.
            return <<<HTML
<script src="https://www.google.com/recaptcha/enterprise.js?render=explicit" async defer></script>
<script>
    window.addEventListener('load', function(){
        function initRecaptcha(){
            if (typeof grecaptcha === 'undefined' || !grecaptcha.enterprise){
                return setTimeout(initRecaptcha, 400);
            }
            var el = document.getElementById('recaptcha-container');
            if(el && !el.getAttribute('data-rendered')){
                grecaptcha.enterprise.render(el, {sitekey: '$siteKey'});
                el.setAttribute('data-rendered','1');
            }
        }
        initRecaptcha();
    });
</script>
HTML;
        }
        return NoCaptcha::renderJs();
    }
}
