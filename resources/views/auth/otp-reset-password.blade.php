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
        input {
            width: 40px;
            height: 40px;
            font-size: 24px;
            margin: 0 5px;
            border: 1px solid #ced4da;
            border-radius: 5px;
        }
        .form-control {
            width: 85%;
            margin: 0 auto;
        }
        h2 {
            font-size: 1.8rem;
            font-weight: bold;
            color: #004085;
        }
        .btn-primary {
            background-color: #06446B;
            width: 85%;
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
        .form-label {
            font-size: 1rem;
            font-weight: 650;
            margin-left: 2.5em;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card text-center p-4">
                    <h2 class="mb-3">BPO BRIDGE</h2>
                    <i class="fa-solid fa-lock fa-5x text-primary mb-3"></i>

                    <!-- New Password Input -->
                    <form action="{{ route('password.reset') }}" method="POST" id="resetForm">
                        @csrf
                        <div class="mb-3 text-start">
                            <label for="newpassword" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="newpassword" 
                                   name="newpassword" placeholder="Enter new password" required>
                        </div>
                        <div class="mb-3 text-start">
                            <label for="confirmpassword" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="confirmpassword" 
                                   name="confirmpassword" placeholder="Confirm password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <!-- Footer -->
                <footer class="text-center mt-4">
                    <small>&copy; BPOBridge Ltd. <a href="#">Contact</a> | <a href="#">Privacy Policy</a></small>
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
