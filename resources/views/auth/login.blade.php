<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BPO Login</title>
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
</head>
<body>
    <header>
        <div class="logo">
            <img src="{{ asset('assets/img/bpo_logo.png') }}" alt="BPO Logo">
        </div>
    </header>

    <main>
        <div class="login-container">
            <div class="image-container">
                <img src="{{ asset('assets/img/login-image.png') }}" alt="Login Image">
            </div>
            <div class="divider"></div>
            <div class="form-container">
                <form id="login-form" method="POST" action="{{ route('login') }}">
                    @csrf
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter email address" required autofocus autocomplete="username" :value="old('email')">
                    <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
                    <div id="email-warning" class="warning">Required Field</div>
                    
                    <label for="password">Password</label>
                    <div class="password-container">
                        <input type="password" id="password" name="password" placeholder="Enter password" required autocomplete="current-password">
                        <span class="toggle-password" onclick="togglePasswordVisibility()">
                            <img id="show-password" src="{{ asset('assets/img/eye-icon-show.png') }}" alt="Show Password">
                            <img id="hide-password" src="{{ asset('assets/img/eye-icon-hide.png') }}" alt="Hide Password" style="display: none;">
                        </span>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
                    <div id="password-warning" class="warning">Required Field</div>

                    <div class="forgot-password-container">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-password">Forgot Password?</a>
                        @endif
                    </div>
                    
                    <button type="submit">Login</button>
                </form>
                <p>Don’t have an account? <a href="{{ route('register') }}">Register</a></p>
            </div>
        </div>
    </main>

    <footer>
        <p>© 2024 - 2024 BPOBridge Ltd. • <a href="privacypolicy.html">Privacy Policy</a></p>
    </footer>

    <script src="{{ asset('assets/js/scripts.js') }}"></script>
</body>
</html>
