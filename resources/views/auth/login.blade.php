<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BPO Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('asset/css/login.css') }}">
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
        <div class="container login-container bg-white p-5">
            <div class="row">
                <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center">
                    <img src="{{ asset('asset/img/login-image.png') }}" alt="Login Image" class="img-fluid">
                </div>
                <div class="col-md-1 d-none d-md-block">
                    <div class="divider"></div>
                </div>
                <div class="col-md-5 mt-5">
                    <form id="login-form" method="POST" action="{{ url('/login') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" required autofocus autocomplete="username" value="{{ old('email') }}">
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger" />
                            <div id="email-warning" class="warning">Required Field</div>
                        </div>
                        
                        <div class="form-group">
                            <label for="password">Password</label>
                            <div class="password-container">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required autocomplete="current-password">
                                <span class="toggle-password" onclick="togglePasswordVisibility()">
                                    <img id="show-password" src="{{ asset('asset/img/eye-icon-show.png') }}" alt="Show Password">
                                    <img id="hide-password" src="{{ asset('asset/img/eye-icon-hide.png') }}" alt="Hide Password" style="display: none;">
                                </span>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger" />
                            <div id="password-warning" class="warning">Required Field</div>
                        </div>

                        <div class="forgot-password-container text-right mb-3">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="forgot-password">Forgot Password?</a>
                            @endif
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </form>
                    <p class="mt-3 text-left">Don’t have an account? <a href="{{ route('register') }}">Register</a></p>
                </div>
            </div>
        </div>
    </main>

    <footer class="text-white py-3 text-center">
        <p>© 2024 - 2024 BPOBridge Ltd. • <a href="privacypolicy.html" class="text-white">Privacy Policy</a></p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ asset('asset/js/scripts.js') }}"></script>
    <script> 
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const showPasswordIcon = document.getElementById('show-password');
            const hidePasswordIcon = document.getElementById('hide-password');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                showPasswordIcon.style.display = 'none';
                hidePasswordIcon.style.display = 'inline';
            } else {
                passwordInput.type = 'password';
                showPasswordIcon.style.display = 'inline';
                hidePasswordIcon.style.display = 'none';
            }
        }
    </script>
</body>
</html>
