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
                <a href="{{ $logo->home_url }}">
                    <img src="{{ asset('/public/storage/uploads/logo/' . $logo->picture) }}" alt="logo">
                </a>
                <h2>Sign up as an Employer</h2>
            </div>

            <form id="employerRegisterForm" method="POST" action="{{ route('employer') }}" novalidate>
                @csrf
                <input type="hidden" name="role_id" value="3">
                <input type="hidden" name="account_type" value="main">

                <!-- Full Name -->
                <div class="input-group mb-3">
                    <label>Full Name</label>
                    <div class="input-wrapper">
                        <span class="icon"><i class="far fa-user"></i></span>
                        <input type="text" id="name" name="name" placeholder="Full Name" value="{{ old('name') }}" required autofocus>
                    </div>
                    <p class="error-text text-sm mt-1" style="color:red;">@error('name') {{ $message }} @enderror</p>
                </div>

                <!-- Username -->
                <div class="input-group mb-3">
                    <label>Username</label>
                    <div class="input-wrapper">
                        <span class="icon"><i class="fas fa-at"></i></span>
                        <input type="text" id="username" name="username" placeholder="Username" value="{{ old('username') }}" required>
                    </div>
                    <p class="error-text text-sm mt-1" style="color:red;">@error('username') {{ $message }} @enderror</p>
                </div>

                <!-- Email -->
                <div class="input-group mb-3">
                    <label>Email address</label>
                    <div class="input-wrapper">
                        <span class="icon"><i class="far fa-envelope"></i></span>
                        <input type="email" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                    </div>
                    <p class="error-text text-sm mt-1" style="color:red;">@error('email') {{ $message }} @enderror</p>
                </div>

                <!-- Password -->
                <div class="input-group mb-3">
                    <label>Password</label>
                    <div class="input-wrapper relative">
                        <span class="icon"><i class="fas fa-lock"></i></span>
                        <input type="password" id="password" name="password" placeholder="Password" required>
                        <span class="toggle-password absolute right-3 top-3 cursor-pointer" onclick="togglePassword('password', this)">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    <p class="error-text text-sm mt-1" style="color:red;">@error('password') {{ $message }} @enderror</p>
                </div>

                <!-- Confirm Password -->
                <div class="input-group mb-3">
                    <label>Confirm Password</label>
                    <div class="input-wrapper relative">
                        <span class="icon"><i class="fas fa-lock"></i></span>
                        <input type="password" id="confirm-password" name="password_confirmation" placeholder="Confirm Password" required>
                        <span class="toggle-password absolute right-3 top-3 cursor-pointer" onclick="togglePassword('confirm-password', this)">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                    <p class="error-text text-sm mt-1" style="color:red;"></p>
                </div>

                <!-- Terms Checkbox -->
                <div class="input-group checkbox-group mb-4">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms" class="ml-2">
                        I agree to the 
                        <a href="{{ route('legal.show', 'terms-of-service') }}" target="_blank" class="text-blue-600 hover:underline">Terms of Service</a> 
                        and 
                        <a href="{{ route('legal.show', 'privacy-policy') }}" target="_blank" class="text-blue-600 hover:underline">Privacy Policy</a>.
                    </label>
                    <p class="error-text text-sm mt-1" style="color:red;">@error('terms') {{ $message }} @enderror</p>
                </div>

                <!-- Submit -->
                <button type="submit" class="login-button w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 rounded-lg font-semibold transition">
                    Sign up
                </button>

                <p class="signup-text text-sm mt-3 text-center">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Sign in</a>
                </p>
            </form>

            <p class="footer text-gray-500 text-xs mt-6 text-center">© 2025 Powered by Kumoyo Technologies.</p>
        </div>
    </div>

    <script>
        // Password toggle
        function togglePassword(fieldId, toggleElement) {
            const passwordField = document.getElementById(fieldId);
            const icon = toggleElement.querySelector('i');
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        // Auto-suggest username
        document.getElementById('name').addEventListener('blur', function() {
            const usernameField = document.getElementById('username');
            if (!usernameField.value.trim()) {
                const suggested = this.value.trim()
                    .toLowerCase()
                    .replace(/\s+/g, '_')
                    .replace(/[^a-z0-9_]/g, '')
                    .substring(0, 15);
                if (suggested) usernameField.value = suggested;
            }
        });

        // Live validation with red feedback
        document.addEventListener('DOMContentLoaded', () => {
            const inputs = document.querySelectorAll('#employerRegisterForm input');
            inputs.forEach(input => {
                input.addEventListener('input', () => validateField(input));
            });
        });

        function validateField(input) {
            const errorText = input.closest('.input-group').querySelector('.error-text');
            let message = '';
            input.style.border = '';

            if (input.name === 'email') {
                const pattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
                if (!input.value.trim()) message = 'Email is required';
                else if (!pattern.test(input.value)) message = 'Enter a valid email';
            }
            if (input.name === 'name' && !input.value.trim()) message = 'Full name is required';
            if (input.name === 'username' && !input.value.trim()) message = 'Username is required';
            if (input.name === 'password' && input.value.length < 6) message = 'Password must be at least 6 characters';
            if (input.name === 'password_confirmation') {
                const password = document.getElementById('password').value;
                if (input.value !== password) message = 'Passwords do not match';
            }
            if (input.name === 'terms' && !input.checked) message = 'You must agree to the terms';

            errorText.textContent = message;
            if (message) input.style.border = '1px solid red';
        }
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</div>
@endsection
