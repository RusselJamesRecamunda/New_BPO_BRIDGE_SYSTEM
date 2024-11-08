<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BPO Bridge - OTP Reset</title>
    <link rel="icon" href="{{ asset('asset/img/browser-icons/bpo_icon.png') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('asset/css/forgot-password.css') }}">
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card text-center shadow p-4">
                    <h2 class="mb-4">BPO BRIDGE</h2>
                    <p>Enter the email address you used when creating the account and we'll send a One Time Pin (OTP) to reset your password.</p>

                    <!-- Email Input -->
                    <form method="POST" action="{{ route('password.email') }}" id="resetForm">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold"><i class="fa-solid fa-envelope me-2 text-primary"></i>Email Address</label>
                            <input 
                                type="email" 
                                class="form-control" 
                                id="email" 
                                name="email" 
                                placeholder="Enter a valid email address" 
                                value="{{ old('email') }}" 
                                required autofocus>
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            <small id="error-message" class="text-danger d-none">⚠️ Required Field</small>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Continue</button>
                    </form>

                    <!-- Links -->
                    <div class="mt-3">
                        <p>Don’t have an account? <a href="{{ route('register') }}">Register</a></p>
                        <p>Nevermind, go back to <a href="{{ route('login') }}">Login</a></p>
                    </div>
                </div>

                <!-- Footer -->
                <footer class="text-center mt-4">
                    <small>&copy;BPOBridge Ltd. <a href="#">Contact</a> | <a href="#">Privacy Policy</a></small>
                </footer>
            </div>
        </div>
    </div> 

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Script -->
    <script src="{{ asset('asset/js/forgot-password.js') }}"></script>

</body>
</html>
