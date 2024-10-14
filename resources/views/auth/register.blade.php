<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('asset/css/register.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- Font Awesome Link -->
</head>
<body>
    <header class="bg-light border-bottom">
        <div class="container-fluid d-flex align-items-center py-1">
            <div class="logo">
                <img src="{{ asset('asset/img/bpo_logo.png') }}" alt="BPO Logo">
            </div>
        </div>
    </header>

    <main class="flex-fill d-flex align-items-center justify-content-center">
        <div class="register-container bg-white p-5">
            <h1>Register</h1>
            <form method="POST" action="{{ route('register') }}" id="register-form">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                    <label for="email">{{ __('Email Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="Enter email address">
                    <div id="email-warning" class="warning" style="display:none;">Please enter a valid email address.</div>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label for="password">{{ __('Password') }}</label>
                    <div class="input-container">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Enter password">
                        <span class="toggle-password" onclick="togglePasswordVisibility('password')">
                            <i class="fa-solid fa-eye show-password"></i>
                            <i class="fa-solid fa-eye-slash hide-password" style="display: none;"></i>
                        </span>
                    </div>
                    <div id="password-warning" class="warning" style="display:none;">Password is required.</div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                    <div class="input-container">
                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm password">
                        <span class="toggle-password" onclick="togglePasswordVisibility('password_confirmation')">
                            <i class="fa-solid fa-eye show-password"></i>
                            <i class="fa-solid fa-eye-slash hide-password" style="display: none;"></i>
                        </span>
                    </div>
                    <div id="confirm-password-warning" class="warning" style="display:none;">Passwords do not match.</div>
                </div>

                <div class="form-group checkbox-group">
                    <input type="checkbox" id="agree-checkbox" name="agree" required>
                    <label for="agree-checkbox">By registering, I agree to the <a href="{{ url('privacypolicy') }}">Privacy Policy</a> and consent to the collection, storage, and use of my personal data as described in that policy.</label>
                    <div id="checkbox-warning" class="warning" style="display:none;">You must agree before submitting.</div>
                </div>

                <button type="submit" class="btn btn-primary btn-block">{{ __('Register') }}</button>
            </form>
            <p>Already have an account? <a href="{{ route('login') }}">{{ __('Login') }}</a></p>
        </div>
    </main>

    <footer class="text-white py-3 text-center">
        <p>© 2024 - 2024 BPOBridge Ltd. • <a href="{{ url('privacypolicy') }}" class="text-white">Privacy Policy</a></p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ asset('asset/js/register.js') }}"></script>
</body>
</html>
