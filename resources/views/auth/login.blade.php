<x-guest-layout>
    <!-- Custom CSS for password toggle -->
    <style>
        .password-toggle-btn {
            position: absolute;
            top: 50%;
            right: 0.75rem;
            transform: translateY(-50%);
            background: none;
            border: none;
            padding: 0.5rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.375rem;
            transition: all 0.2s ease-in-out;
            z-index: 10;
        }
        
        
        
        .password-toggle-btn:focus {
            outline: none;
            
        }
        
        .password-toggle-btn:active {
            transform: translateY(-50%) scale(0.95);
        }
        
        .password-input-wrapper {
            position: relative;
        }
        
        .password-input {
            padding-right: 3rem !important;
        }
        
        /* Responsive adjustments */
        @media (max-width: 640px) {
            .password-toggle-btn {
                right: 0.5rem;
                padding: 0.375rem;
            }
            
            .password-input {
                padding-right: 2.5rem !important;
            }
        }
        
        /* Focus styles for better accessibility */
        .password-input:focus + .password-toggle-btn {
            color: #3b82f6;
        }
        
        /* Icon transition */
        .password-toggle-btn svg {
            transition: all 0.2s ease-in-out;
        }
        
        .password-toggle-btn:hover svg {
            color: #374151;
        }
    </style>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <div class="password-input-wrapper">
                <x-text-input id="password" class="block mt-1 w-full password-input"
                        type="password"
                        name="password"
                        required autocomplete="current-password" />
                
                <button type="button" class="password-toggle-btn" onclick="togglePassword()">
                    <svg id="eye-icon" class="h-5 w-5 text-gray-400 hover:text-gray-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <svg id="eye-slash-icon" class="h-5 w-5 text-gray-400 hover:text-gray-600 transition-colors duration-200 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L12 12m-2.122-2.122L7.758 7.758M9.878 9.878L7.758 7.758m2.122 2.12L12 12m0 0l2.122 2.122M12 12l-2.122-2.122"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"></path>
                    </svg>
                </button>
            </div>

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <script>
            function togglePassword() {
                const passwordInput = document.getElementById('password');
                const eyeIcon = document.getElementById('eye-icon');
                const eyeSlashIcon = document.getElementById('eye-slash-icon');
                const toggleBtn = document.querySelector('.password-toggle-btn');
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.classList.add('hidden');
                    eyeSlashIcon.classList.remove('hidden');
                    toggleBtn.setAttribute('aria-label', 'Hide password');
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.classList.remove('hidden');
                    eyeSlashIcon.classList.add('hidden');
                    toggleBtn.setAttribute('aria-label', 'Show password');
                }
                
                // Add a slight animation effect
                toggleBtn.style.transform = 'translateY(-50%) scale(0.95)';
                setTimeout(() => {
                    toggleBtn.style.transform = 'translateY(-50%) scale(1)';
                }, 100);
            }
            
            // Initialize button aria-label
            document.addEventListener('DOMContentLoaded', function() {
                const toggleBtn = document.querySelector('.password-toggle-btn');
                if (toggleBtn) {
                    toggleBtn.setAttribute('aria-label', 'Show password');
                }
            });
        </script>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('admin.password.request') }}">
                Lupa Password?
            </a>

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
