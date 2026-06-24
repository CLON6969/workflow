@php
    $logo = App\Models\Logo::first();
@endphp

@extends('layouts.signup')

@section('content')
<div class="body">
    <img class="body-img" src="{{ asset('/public/storage/uploads/logo/' . $logo->background_picture) }}" alt="background">

    <div class="login-container">
        <div class="login-box">
            <div class="text-center">
                <a href="{{$logo->home_url}}">
                    
                    <img src="{{ asset('/public/storage/uploads/logo/' . $logo->picture) }}" alt="logo">
                </a>
                <h2>Sign up</h2>
            </div>

            <form id="registerForm" method="POST" action="{{ route('register') }}" novalidate>
                @csrf
                <input type="hidden" name="role_id" value="4">
                <input type="hidden" name="account_type" value="main">

                <!-- Full Name -->
                <div class="input-group mb-3">
                    <label>Full Name</label>
                    <div class="input-wrapper">
                        <span class="icon"><i class="far fa-user"></i></span>
                        <input type="text" id="name" name="name" placeholder="Full Name"
                               value="{{ old('name') }}" required autofocus>
                    </div>
                    <p class="error-text">@error('name') {{ $message }} @enderror</p>
                </div>

                <!-- Username -->
                <div class="input-group mb-3">
                    <label>Username</label>
                    <div class="input-wrapper">
                        <span class="icon"><i class="fas fa-at"></i></span>
                        <input type="text" id="username" name="username" placeholder="Username"
                               value="{{ old('username') }}" required>
                    </div>
                    <p class="error-text">@error('username') {{ $message }} @enderror</p>
                </div>

                <!-- Email -->
                <div class="input-group mb-3">
                    <label>Email address</label>
                    <div class="input-wrapper">
                        <span class="icon"><i class="far fa-envelope"></i></span>
                        <input type="email" id="email" name="email" placeholder="Email"
                               value="{{ old('email') }}" required>
                    </div>
                    <p id="emailError" class="error-text" style="display: none;"></p>
                    @error('email') <p class="error-text">{{ $message }}</p> @enderror
                </div>

                <!-- Password -->
                <div class="input-group mb-3">
                    <label>Password</label>
                    <div class="input-wrapper relative">
                        <span class="icon"><i class="fas fa-lock"></i></span>
                        <input type="password" id="password" name="password" placeholder="Password" required>
                        <span class="toggle-password" onclick="togglePassword('password', this)">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    <p id="passwordError" class="error-text" style="display: none;"></p>
                    @error('password') <p class="error-text">{{ $message }}</p> @enderror
                </div>

                <!-- Confirm Password -->
                <div class="input-group mb-3">
                    <label>Confirm Password</label>
                    <div class="input-wrapper relative">
                        <span class="icon"><i class="fas fa-lock"></i></span>
                        <input type="password" id="confirm-password" name="password_confirmation"
                               placeholder="Confirm Password" required>
                        <span class="toggle-password" onclick="togglePassword('confirm-password', this)">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    <p id="confirmError" class="error-text" style="display: none;"></p>
                </div>

                <!-- Terms -->
                <div class="input-group mb-4">
                    <div class="checkbox-wrapper">
                        <input type="checkbox" id="terms" name="terms" required>
                        <label for="terms">
                            I agree to the
                            <a href="{{ route('legal.show', 'terms-of-service') }}" target="_blank">Terms of Service</a>
                            and
                            <a href="{{ route('legal.show', 'privacy-policy') }}" target="_blank">Privacy Policy</a>.
                        </label>
                    </div>
                    <p class="error-text">@error('terms') {{ $message }} @enderror</p>
                </div>

                <!-- Main Sign up Button -->
                <button type="submit" id="submitBtn" class="login-button" disabled>
                    <span class="button-text">Sign up</span>
                    <span class="loading-spinner" style="display:none;">
                        <i class="fas fa-spinner fa-spin"></i> Signing up...
                    </span>
                </button>

                <!-- Divider -->
                <div class="separator">or sign up with</div>

                <!-- Social Signup Buttons with loading -->
                <div class="social-login">
                    <a href="{{ route('social.redirect', 'google') }}" class="social-btn google" data-provider="Google">
                        <span class="btn-text"><i class="fab fa-google"></i> Google</span>
                        <span class="loading-spinner" style="display:none;">
                            <i class="fas fa-spinner fa-spin"></i> Connecting...
                        </span>
                    </a>

                    <a href="{{ route('social.redirect', 'facebook') }}" class="social-btn facebook" data-provider="Facebook">
                        <span class="btn-text"><i class="fab fa-facebook-f"></i> Facebook</span>
                        <span class="loading-spinner" style="display:none;">
                            <i class="fas fa-spinner fa-spin"></i> Connecting...
                        </span>
                    </a>


                </div>

                <p class="signup-text">
                    Already have an account?
                    <a href="{{ route('login') }}">Sign in</a>
                </p>
            </form>

            <p class="footer">© 2025 Powered byWorkflow Technologies.</p>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        function togglePassword(fieldId, toggleElement) {
            const field = document.getElementById(fieldId);
            const icon = toggleElement.querySelector('i');
            if (field.type === 'password') {
                field.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                field.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        document.getElementById('name').addEventListener('blur', function() {
            const usernameField = document.getElementById('username');
            if (!usernameField.value.trim()) {
                usernameField.value = this.value
                    .toLowerCase()
                    .replace(/\s+/g, '_')
                    .replace(/[^a-z0-9_]/g, '')
                    .substring(0, 15);
            }
        });
    </script>

    <!-- Validation + Main button loading -->
    <script>
        const form = document.getElementById('registerForm');
        const submitBtn = document.getElementById('submitBtn');
        const buttonText = submitBtn.querySelector('.button-text');
        const spinner = submitBtn.querySelector('.loading-spinner');

        const emailField = document.getElementById('email');
        const passwordField = document.getElementById('password');
        const confirmField = document.getElementById('confirm-password');
        const termsCheckbox = document.getElementById('terms');

        const emailError = document.getElementById('emailError');
        const passwordError = document.getElementById('passwordError');
        const confirmError = document.getElementById('confirmError');

        let emailTouched = false;
        let passwordTouched = false;
        let confirmTouched = false;

        emailField.addEventListener('input', () => { emailTouched = true; validateForm(); });
        passwordField.addEventListener('input', () => { passwordTouched = true; validateForm(); });
        confirmField.addEventListener('input', () => { confirmTouched = true; validateForm(); });

        emailField.addEventListener('blur', () => { emailTouched = true; validateForm(); });
        passwordField.addEventListener('blur', () => { passwordTouched = true; validateForm(); });
        confirmField.addEventListener('blur', () => { confirmTouched = true; validateForm(); });

        termsCheckbox.addEventListener('change', validateForm);

        [emailField, passwordField, confirmField].forEach(field => {
            field.addEventListener('animationstart', () => {
                if (field.matches(':-webkit-autofill')) {
                    if (field === emailField) emailTouched = true;
                    if (field === passwordField) passwordTouched = true;
                    if (field === confirmField) confirmTouched = true;
                    validateForm();
                }
            });
        });

        function validateForm() {
            let isValid = true;

            const email = emailField.value.trim();
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (emailTouched) {
                if (!email) {
                    emailError.textContent = 'Email is required.';
                    emailError.style.display = 'block';
                    setInvalid(emailField);
                    isValid = false;
                } else if (!emailRegex.test(email)) {
                    emailError.textContent = 'Please enter a valid email address.';
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

            const password = passwordField.value;
            if (passwordTouched) {
                if (!password) {
                    passwordError.textContent = 'Password is required.';
                    passwordError.style.display = 'block';
                    setInvalid(passwordField);
                    isValid = false;
                } else if (password.length < 6) {
                    passwordError.textContent = 'Password must be at least 6 characters.';
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

            const confirm = confirmField.value;
            if (confirmTouched || passwordTouched) {
                if (!confirm) {
                    confirmError.textContent = 'Please confirm your password.';
                    confirmError.style.display = 'block';
                    setInvalid(confirmField);
                    isValid = false;
                } else if (confirm !== password) {
                    confirmError.textContent = 'Passwords do not match.';
                    confirmError.style.display = 'block';
                    setInvalid(confirmField);
                    isValid = false;
                } else {
                    confirmError.style.display = 'none';
                    setValid(confirmField);
                }
            } else {
                confirmError.style.display = 'none';
            }

            if (!termsCheckbox.checked) {
                isValid = false;
            }

            submitBtn.disabled = !isValid;
        }

        function setValid(field) {
            field.classList.remove('invalid');
            field.classList.add('valid');
        }

        function setInvalid(field) {
            field.classList.remove('valid');
            field.classList.add('invalid');
        }

        // Main form submit loading
        form.addEventListener('submit', function(e) {
            if (!submitBtn.disabled) {
                submitBtn.disabled = true;
                buttonText.style.display = 'none';
                spinner.style.display = 'inline-block';
            }
        });

        validateForm();
    </script>

    <!-- Social buttons loading animation -->
    <script>
        document.querySelectorAll('.social-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                const text = this.querySelector('.btn-text');
                const spinner = this.querySelector('.loading-spinner');

                // Show spinner and disable link visually
                text.style.display = 'none';
                spinner.style.display = 'flex';

                // Optional: prevent double-click (though redirect will happen)
                this.style.pointerEvents = 'none';
                this.style.opacity = '0.7';
            });
        });
    </script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Styles -->
    <style>
        .error-text {
            color: #e3342f;
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

        .input-wrapper input {
            width: 100%;
            padding: 10px 10px 10px 40px;
            border: 1px solid #ccc;
            border-radius: 6px;
            background: #fff;
            color: #000;
            box-shadow: none;
            transition: border-color 0.2s;
        }

        .input-wrapper input:focus,
        .input-wrapper input.valid {
            border-color: #2563eb !important;
            outline: none;
            box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.2);
        }

        .input-wrapper input.invalid {
            border-color: #e3342f !important;
        }

        /* AUTOFILL FIX */
        .input-wrapper input:-webkit-autofill,
        .input-wrapper input:-webkit-autofill:hover,
        .input-wrapper input:-webkit-autofill:focus,
        .input-wrapper input:-webkit-autofill:active {
            -webkit-text-fill-color: #000 !important;
            caret-color: #000 !important;
            background-color: #fff !important;
            background-clip: text !important;
            border-color: #2563eb !important;
            box-shadow: 0 0 0 1000px #fff inset !important;
            transition: background-color 5000s ease-in-out 0s;
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
            margin-top: 10px;
        }

        .login-button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .separator {
            text-align: center;
            margin: 15px 0;
            font-size: 0.9rem;
            color: #666;
        }

        .social-login {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
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

        /* Checkbox beside text */
        .checkbox-wrapper {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-top: 8px;
        }

        .checkbox-wrapper input[type="checkbox"] {
            margin: 0;
            margin-top: 3px;
            flex-shrink: 0;
        }

        .checkbox-wrapper label {
            margin: 0;
            line-height: 1.5;
            cursor: pointer;
            flex: 1;
        }
    </style>
</div>
@endsection