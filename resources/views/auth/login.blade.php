@php
    $logo = App\Models\Logo::first();
@endphp

@extends('layouts.sigin')

@section('content')
<div class="body">
    <img class="body-img" src="{{ asset('/public/storage/uploads/logo/'  . $logo->background_picture) }}" alt="background">

    <div class="login-container">
        <div class="login-box">
            <div class="text-center">
                <a href="{{$logo->home_url}}">
                    
                    <img src="{{ asset('/public/storage/uploads/logo/' . $logo->picture) }}" alt="logo">
                </a>
                <h2>Sign in</h2>
            </div>

            <form id="loginForm" method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="input-group">
                    <label>Email address</label>
                    <div class="input-wrapper">
                        <span class="icon"><i class="far fa-envelope"></i></span>
                        <input type="email" name="email" id="email" placeholder="Email"
                               value="{{ old('email') }}" required autofocus>
                    </div>
                    <span id="emailError" class="text-danger error-text" style="display: none;"></span>
                    @error('email')
                        <span class="text-danger error-text">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="input-group">
                    <label>Password</label>
                    <div class="input-wrapper">
                        <span class="icon"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" id="password" placeholder="Password" required>
                        <span id="togglePassword" class="toggle-password" style="cursor:pointer;">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    <span id="passwordError" class="text-danger error-text" style="display: none;"></span>
                    @error('password')
                        <span class="text-danger error-text">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Options -->
                <div class="options">
                    <label class="remember-me">
                        <input type="checkbox" name="remember">
                        Remember me
                    </label>
                    <a href="{{ route('password.request') }}" class="forgot-password">
                        Forgot password?
                    </a>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="loginButton" class="login-button" disabled>
                    <span class="button-text">Sign in</span>
                    <span class="loading-spinner" style="display:none;">
                        <i class="fas fa-spinner fa-spin"></i> Signing in...
                    </span>
                </button>

                <!-- Divider -->
                <div class="separator">or continue with</div>

                <!-- Social Login Buttons -->
                <div class="social-login">
                    <a href="{{ route('social.redirect', 'google') }}" class="social-btn google" data-provider="Google">
                        <span class="btn-text"><i class="fab fa-google"></i> Google</span>
                        <span class="loading-spinner" style="display:none;">
                            <i class="fas fa-spinner fa-spin"></i> Connecting...
                        </span>
                    </a>

<a href="{{ route('social.redirect', 'facebook') }}"
   class="social-btn facebook disabled-link"
   data-provider="Facebook"
   aria-disabled="true"
   tabindex="-1">
    <span class="btn-text"><i class="fab fa-facebook-f"></i> Facebook</span>
    <span class="loading-spinner" style="display:none;">
        <i class="fas fa-spinner fa-spin"></i> Connecting...
    </span>
</a>

                </div>

                <div class="separator">or</div>

                <p class="signup-text">
                    New ? <a href="{{ route('register') }}">Sign up</a>
                </p>
            </form>

            <p class="footer">© 2025 Powered byWorkflow Technologies.</p>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        const form = document.getElementById('loginForm');
        const button = document.getElementById('loginButton');
        const emailField = document.getElementById('email');
        const passwordField = document.getElementById('password');
        const emailError = document.getElementById('emailError');
        const passwordError = document.getElementById('passwordError');
        const buttonText = button.querySelector('.button-text');
        const spinner = button.querySelector('.loading-spinner');

        let emailTouched = false;
        let passwordTouched = false;
        let usingSocialLogin = false; // NEW: Track if user clicked social button

        emailField.addEventListener('input', () => { emailTouched = true; validateForm(); });
        passwordField.addEventListener('input', () => { passwordTouched = true; validateForm(); });

        emailField.addEventListener('blur', () => { emailTouched = true; validateForm(); });
        passwordField.addEventListener('blur', () => { passwordTouched = true; validateForm(); });

        [emailField, passwordField].forEach(field => {
            field.addEventListener('animationstart', () => {
                if (field.matches(':-webkit-autofill')) {
                    if (field === emailField) emailTouched = true;
                    if (field === passwordField) passwordTouched = true;
                    validateForm();
                }
            });
        });

        function validateForm() {
            let isValid = true;

            // Only validate email/password if NOT using social login
            if (!usingSocialLogin) {
                const email = emailField.value.trim();
                const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (emailTouched) {
                    if (!email) {
                        emailError.textContent = "Email is required.";
                        emailError.style.display = 'block';
                        setInvalid(emailField);
                        isValid = false;
                    } else if (!regex.test(email)) {
                        emailError.textContent = "Please enter a valid email address.";
                        emailError.style.display = 'block';
                        setInvalid(emailField);
                        isValid = false;
                    } else {
                        emailError.style.display = 'none';
                        setValid(emailField);
                    }
                } else {
                    emailError.style.display = 'none';
                }

                const password = passwordField.value.trim();
                if (passwordTouched) {
                    if (!password) {
                        passwordError.textContent = "Password is required.";
                        passwordError.style.display = 'block';
                        setInvalid(passwordField);
                        isValid = false;
                    } else if (password.length < 6) {
                        passwordError.textContent = "Password must be at least 6 characters.";
                        passwordError.style.display = 'block';
                        setInvalid(passwordField);
                        isValid = false;
                    } else {
                        passwordError.style.display = 'none';
                        setValid(passwordField);
                    }
                } else {
                    passwordError.style.display = 'none';
                }
            } else {
                // If using social, hide all errors and enable button (though button is for email login)
                emailError.style.display = 'none';
                passwordError.style.display = 'none';
                setValid(emailField);
                setValid(passwordField);
            }

            button.disabled = !isValid || usingSocialLogin; // Disable main button if social is used (optional)
        }

        function setInvalid(field) {
            field.classList.remove('valid');
            field.classList.add('invalid');
        }

        function setValid(field) {
            field.classList.remove('invalid');
            field.classList.add('valid');
        }

        // Password toggle
        document.getElementById('togglePassword').addEventListener('click', function() {
            const icon = this.querySelector('i');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        });

        // Main form submit loading
        form.addEventListener('submit', function(e) {
            if (!button.disabled) {
                button.disabled = true;
                buttonText.style.display = 'none';
                spinner.style.display = 'inline-flex';
            }
        });

        // Social buttons: show loading + skip email/password validation
        document.querySelectorAll('.social-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                usingSocialLogin = true; // Mark that social is being used
                validateForm(); // Hide any email/password errors immediately

                const text = this.querySelector('.btn-text');
                const spinner = this.querySelector('.loading-spinner');

                text.style.display = 'none';
                spinner.style.display = 'flex';

                this.style.pointerEvents = 'none';
                this.style.opacity = '0.7';
            });
        });

        validateForm();
    </script>

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Styles (unchanged) -->
    <style>

    .disabled-link {
    pointer-events: none;
    cursor: not-allowed;
    opacity: 0.6;
}
        .text-danger {
            color: #e3342f !important;
            font-size: 0.85rem;
            margin-top: 4px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper .icon {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #000;
            font-size: 1.1rem;
            pointer-events: none;
            z-index: 2;
        }


        input {
            width: 100%;
            padding: 10px 10px 10px 40px;
            border: 1px solid #ccc;
            border-radius: 6px;
            background: #fff;
            color: #000;
            box-shadow: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input:focus,
        input.valid {
            border-color: #2563eb !important;
            outline: none;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
        }

        input.invalid {
            border-color: #e3342f !important;
        }

        /* AUTOFILL FIX */
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active {
            -webkit-text-fill-color: #000 !important;
            caret-color: #000 !important;
            background-color: #fff !important;
            background-clip: content-box !important;
            border-color: #2563eb !important;
            box-shadow: 0 0 0 1000px #fff inset !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        .input-wrapper .icon {
            color: #000 !important;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #000;
            z-index: 2;
        }

        .login-button {
            width: 100%;
            background: #2563eb;
            color: #fff;
            padding: 10px;
            border-radius: 6px;
            font-weight: 600;
            border: none;
        }

        .login-button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .social-login {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin-top: 10px;
        }

        .social-btn {
            padding: 10px;
            border-radius: 6px;
            color: #fff;
            font-weight: 600;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            position: relative;
        }

        .social-btn .btn-text,
        .social-btn .loading-spinner {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .google { background: #db4437; }
        .facebook { background: #1877f2; }
        .apple { background: #000; }
        .twitter { background: #1da1f2; }

        .loading-spinner {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        @media (max-width: 600px) {
            .login-box {
                width: 90%;
            }
        }
    </style>
</div>
@endsection