<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="icon" href="{{ asset('asset/img/browser-icons/bpo_icon.png') }}">
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

                <!-- First Name and Last Name -->
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="first_name">{{ __('First Name') }}</label>
                        <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" placeholder="First Name">
                        @error('first_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="last_name">{{ __('Last Name') }}</label>
                        <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" placeholder="Last Name">
                        @error('last_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>


                <!-- Email Address -->
                <div class="form-group">
                    <label for="email">{{ __('Email Address') }}</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="Enter email address">
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
                            <i class="fa-solid fa-eye-slash hide-password" style="display: inline;"></i>
                            <i class="fa-solid fa-eye show-password" style="display: none;"></i>
                        </span>
                    </div>
                    <small id="password-validation-warning" class="text-danger" style="display: none;">
                        <ul>
                            <li>Password must be at least 12 characters long</li>
                            <li>Contain an uppercase letter</li>
                            <li>Contain a lowercase letter</li>
                            <li>Contain a symbol</li>
                        </ul>
                    </small>
                    @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                    <div class="input-container">
                        <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm password">
                        <span class="toggle-password" onclick="togglePasswordVisibility('password_confirmation')">
                            <i class="fa-solid fa-eye-slash hide-password" style="display: inline;"></i>
                            <i class="fa-solid fa-eye show-password" style="display: none;"></i>
                        </span>
                    </div>
                    <small id="confirm-password-warning" class="text-danger" style="display: none;">
                        Passwords do not match.
                    </small>
                    @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mt-4">
                    <!-- Render the necessary JavaScript for the reCAPTCHA widget -->
                    {!! NoCaptcha::renderJs() !!}
                    <!-- Display the reCAPTCHA widget -->
                    {!! NoCaptcha::display() !!}
                    <!-- Display validation error message for the reCAPTCHA response -->
                    <span style="color: red;">
                        @if($errors->has('g-recaptcha-response'))
                        <!-- Show the first error message related to reCAPTCHA -->
                        {{$errors->first('g-recaptcha-response')}}
                        @endif
                    </span>
                </div>

                <div class="form-group checkbox-group">
                    <input type="checkbox" id="agree-checkbox" name="agree" required>
                    <label for="agree-checkbox">By registering, I agree to the <a href="{{ url('privacypolicy') }}">Privacy Policy</a> and consent to the collection, storage, and use of my personal data as described in that policy.</label>
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