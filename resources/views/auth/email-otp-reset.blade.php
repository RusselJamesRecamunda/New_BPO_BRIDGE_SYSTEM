<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BPO-BRIDGE Password Reset</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset/css/email-otp.css') }}">
</head>

<body>
    <center>
        <div class="container-sec">
            <div class="text-center">
                <div><i class="fas fa-lock otp-lock"></i></div>
                <div class="welcome-section">
                    <div class="app-name">
                        --- BPO-BRIDGE ---
                    </div>
                    <div class="welcome-text">
                        Password Reset OTP
                    </div>

                    <div class="verify-text">
                        Please Verify Your Email Address
                    </div>
                    <div class="email-icon">
                        <i class="fas fa-envelope-open"></i>
                    </div>
                </div>
                <p>You requested a password reset. Please use the OTP code below:</p>
                <div class="otp-code">
                    <h2>{{ $otpCode }}</h2>
                </div>
                <p class="mt-4">Please use this OTP to verify your password reset request. The OTP is valid for the next 10 minutes.</p>
            </div>
            <div class="footer-text">
                <p>If you did not request this OTP, please <a href="#">contact us</a> immediately.</p>
                <p>Thank you,<br>BPO-BRIDGE 2024 © All rights reserved.</p>
            </div>
        </div>
    </center>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
