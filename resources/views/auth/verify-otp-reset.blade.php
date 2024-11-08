<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BPO Bridge - OTP Verification</title>
    <link rel="icon" href="{{ asset('asset/img/browser-icons/bpo_icon.png') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
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
            color: #004085;
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
                    <h5>Enter OTP Code</h5>

                    <form id="otpForm" class="mb-3">
                        @csrf
                        <input type="hidden" name="otp_code" id="otp_code">

                        <div class="d-flex justify-content-center mb-3">
                            @for ($i = 0; $i < 6; $i++)
                                <input 
                                    type="text" 
                                    class="otp-input" 
                                    maxlength="1" 
                                    required 
                                    data-index="{{ $i }}" 
                                    id="otp-{{ $i }}" 
                                    oninput="moveToNext(this)">
                            @endfor 
                        </div>

                        <button type="button" class="btn btn-primary w-75" id="verifyOtpButton">Verify OTP Code</button>
                    </form>

                    <p class="text-danger">Click resend if you didn't receive the code</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function moveToNext(input) {
            const index = parseInt(input.getAttribute('data-index'));
            const nextInput = document.getElementById(`otp-${index + 1}`);
            const prevInput = document.getElementById(`otp-${index - 1}`);

            if (input.value.length === 1 && nextInput) {
                nextInput.focus();
            } else if (input.value === '' && prevInput) {
                prevInput.focus();
            }
        }

        const otpInputs = document.querySelectorAll('.otp-input');
        otpInputs.forEach(input => {
            input.addEventListener('input', function() {
                let otpValue = '';
                otpInputs.forEach(input => {
                    otpValue += input.value;
                });
                document.getElementById('otp_code').value = otpValue;
            });
        });

        document.getElementById('verifyOtpButton').addEventListener('click', function() {
            const otpCode = document.getElementById('otp_code').value;

            fetch('{{ url("/verify-otp-reset") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ otp_code: otpCode })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    window.location.href = '{{ route("password.reset") }}?email=' + encodeURIComponent(data.email);
                } else {
                    alert(data.message || 'Invalid OTP. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });
    </script>
</body>
</html>
