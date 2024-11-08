<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BPO Bridge - OTP Verification</title>
    <link rel="icon" href="{{ asset('asset/img/browser-icons/bpo_icon.png') }}">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
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

                <!-- Footer -->
                <footer class="text-center mt-4">
                    <small>&copy;BPOBridge Ltd. <a href="#">Contact</a> | <a href="#">Privacy Policy</a></small>
                </footer>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h5 class="modal-title text-center w-100" id="successModalLabel">Successfully Registered New Account!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img src="{{ asset('asset/img/cheers.png') }}" alt="Success Icon" class="mb-3" style="width: 240px; height: auto;">
                </div>
                <div class="modal-footer justify-content-center">
                    <a href="{{ route('login') }}" class="btn btn-primary fw-bold w-50"><i class="fa-solid fa-arrow-left fw-bold me-3"></i>Go back to login</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Auto-move to the next input and merge OTP inputs
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

        // Merge OTP values into a hidden input
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

        // Handle OTP verification
        document.getElementById('verifyOtpButton').addEventListener('click', function() {
            const otpCode = document.getElementById('otp_code').value;

            // AJAX request to verify the OTP
            fetch('{{ url("/verify-otp") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ otp_code: otpCode })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                    successModal.show(); // Show the modal on success
                } else {
                    // Handle errors (showing on the page or alert)
                    alert(data.message || 'An error occurred. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
            });
        });

        // Show modal on successful OTP verification if already logged in
        document.addEventListener('DOMContentLoaded', function () {
            if ("{{ session('success') }}") {
                const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
            }
        });
    </script>
</body>
</html>
