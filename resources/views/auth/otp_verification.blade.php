<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BPO Bridge - OTP Verification</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .otp-input {
            width: 50px;
            height: 50px;
            font-size: 24px;
            text-align: center;
            margin: 0 5px;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }
        h2 {
            font-size: 1.8rem;
            font-weight: bold;
            color: #004085; /* Navy Blue */
        }
        .btn-primary {
            background-color: #06446B;
        }
        .btn-primary:hover {
            background-color: #003a75;
        }
        footer {
            margin-top: 20px;
            color: #999;
        }
        
        footer a {
            color: #999;
            text-decoration: none;
        }
        
        footer a:hover {
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card text-center p-4">
                    <h2 class="mb-3">BPO BRIDGE</h2>
                    <i class="fas fa-check-circle fa-5x text-success mb-3"></i>
                    <h5>Enter OTP Code</h5>

                    <form action="{{ route('verify.otp') }}" method="POST" id="otpForm" class="mb-3">
                        @csrf
                        <div class="d-flex justify-content-center mb-3">
                            <input type="text" name="otp[]" class="otp-input" maxlength="1" required>
                            <input type="text" name="otp[]" class="otp-input" maxlength="1" required>
                            <input type="text" name="otp[]" class="otp-input" maxlength="1" required>
                            <input type="text" name="otp[]" class="otp-input" maxlength="1" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-75">Verify OTP Code</button>
                    </form>

                    <p class="text-danger">Click resend if you didn't receive the code</p>
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
    <script src="{{ asset('js/otp.js') }}"></script> <!-- Adjust if you have specific JS for OTP functionality -->
</body>
</html>
