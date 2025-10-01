<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SimpleCaptchaService
{
    /**
     * Generate simple math captcha
     */
    public function generate(): array
    {
        $operations = ['+', '-', '*'];
        $operation = $operations[array_rand($operations)];

        switch ($operation) {
            case '+':
                $num1 = rand(1, 50);
                $num2 = rand(1, 50);
                $answer = $num1 + $num2;
                $question = "{$num1} + {$num2}";
                break;

            case '-':
                $num1 = rand(10, 100);
                $num2 = rand(1, $num1 - 1); // Ensure positive result
                $answer = $num1 - $num2;
                $question = "{$num1} - {$num2}";
                break;

            case '*':
                $num1 = rand(1, 12);
                $num2 = rand(1, 12);
                $answer = $num1 * $num2;
                $question = "{$num1} × {$num2}";
                break;

            default:
                $num1 = rand(1, 20);
                $num2 = rand(1, 20);
                $answer = $num1 + $num2;
                $question = "{$num1} + {$num2}";
        }

        // Store answer in session
        $captchaKey = 'captcha_answer_' . uniqid();
        Session::put($captchaKey, $answer);
        Session::put('captcha_key', $captchaKey);

        return [
            'question' => $question,
            'key' => $captchaKey,
            'answer' => $answer // For debugging only, remove in production
        ];
    }

    /**
     * Verify captcha answer
     */
    public function verify(Request $request): bool
    {
        $userAnswer = $request->input('captcha_answer');
        $captchaKey = $request->input('captcha_key') ?? Session::get('captcha_key');

        if (!$captchaKey || !$userAnswer) {
            return false;
        }

        $correctAnswer = Session::get($captchaKey);

        // Clean up session
        Session::forget($captchaKey);
        Session::forget('captcha_key');

        return $correctAnswer && (int)$userAnswer === (int)$correctAnswer;
    }

    /**
     * Check if captcha is required
     */
    public function isRequired(): bool
    {
        return config('captcha.required', true);
    }

    /**
     * Generate captcha HTML
     */
    public function generateHtml(): string
    {
        if (!$this->isRequired()) {
            return '';
        }

        $captcha = $this->generate();

        return '
        <div class="mb-3">
            <label for="captcha_answer" class="form-label">
                <i class="bi bi-shield-check"></i> Verifikasi: Berapa hasil dari <strong>' . $captcha['question'] . '</strong>?
            </label>
            <input type="number"
                   class="form-control"
                   id="captcha_answer"
                   name="captcha_answer"
                   placeholder="Masukkan jawaban"
                   required>
            <input type="hidden" name="captcha_key" value="' . $captcha['key'] . '">
            <small class="form-text text-muted">Silakan hitung dan masukkan jawabannya untuk melanjutkan.</small>
        </div>';
    }

    /**
     * Get validation rules for forms
     */
    public function getValidationRules(): array
    {
        if (!$this->isRequired()) {
            return [];
        }

        return [
            'captcha_answer' => 'required|integer',
            'captcha_key' => 'required|string'
        ];
    }

    /**
     * Get validation messages
     */
    public function getValidationMessages(): array
    {
        return [
            'captcha_answer.required' => 'Jawaban captcha wajib diisi.',
            'captcha_answer.integer' => 'Jawaban captcha harus berupa angka.',
            'captcha_key.required' => 'Kunci captcha tidak valid.'
        ];
    }
}
