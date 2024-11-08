<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BPO Bridge - Reset Password</title>
    <link rel="icon" href="{{ asset('asset/img/browser-icons/bpo_icon.png') }}">

    <!-- Bootstrap CSS --> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('asset/css/reset-password.css') }}">
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card text-center p-4">
                    <h2 class="mb-3">BPO BRIDGE</h2>
                    <i class="fa-solid fa-lock fa-5x text-primary mb-3"></i>

                    <!-- New Password Input -->
                    <form action="{{ route('password.update') }}" method="POST" id="resetForm">
                        @csrf
                        <input type="hidden" name="email" class="form-control" value="{{ old('email', session('reset_email')) }}" required autofocus>
                        
                        <div class="mb-3 text-start position-relative">
                            <label for="newpassword" class="form-label">New Password</label>
                            <div class="position-relative">
                                <input type="password" class="form-control pe-5" id="newpassword" name="password" placeholder="Enter new password" required>
                                <i class="fa-regular fa-eye-slash position-absolute toggle-password-icon" id="toggleNewPassword"></i>
                            </div>
                        </div>

                        <div class="mb-3 text-start position-relative">
                            <label for="confirmpassword" class="form-label">Confirm Password</label>
                            <div class="position-relative">
                                <input type="password" class="form-control pe-5" id="confirmpassword" name="password_confirmation" placeholder="Confirm password" required>
                                <i class="fa-regular fa-eye-slash position-absolute toggle-password-icon" id="toggleConfirmPassword"></i>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <!-- Footer -->
                <footer class="text-center mt-4">
                    <small>&copy; BPO-Bridge Ltd. <a href="#">Contact</a> | <a href="#">Privacy Policy</a></small>
                </footer>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Script -->
    <script src="{{ asset('asset/js/otp-reset-password.js') }}"></script>
</body>
</html>
