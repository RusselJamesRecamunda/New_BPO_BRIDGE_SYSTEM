document.addEventListener("DOMContentLoaded", function () {
    // Check if verifyOtpButton exists before adding event listener
    const verifyOtpButton = document.getElementById("verifyOtpButton");
    if (verifyOtpButton) {
        verifyOtpButton.addEventListener("click", function () {
            const otpCode = document.getElementById("otp_code").value;
            const email = document.querySelector('input[name="email"]').value;

            fetch('{{ url("/verify-otp-reset") }}', {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
                body: JSON.stringify({ otp_code: otpCode, email: email }),
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.json();
                })
                .then((data) => {
                    if (data.success) {
                        window.location.href = '{{ route("password.reset") }}';
                    } else {
                        alert(data.message || "Invalid OTP. Please try again.");
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    alert("An error occurred. Please try again.");
                });
        });
    }

    // Password visibility toggles
    const toggleNewPassword = document.getElementById("toggleNewPassword");
    const toggleConfirmPassword = document.getElementById(
        "toggleConfirmPassword"
    );

    if (toggleNewPassword) {
        toggleNewPassword.addEventListener("click", function () {
            const newPassword = document.getElementById("newpassword");
            togglePasswordVisibility(newPassword, this);
        });
    }

    if (toggleConfirmPassword) {
        toggleConfirmPassword.addEventListener("click", function () {
            const confirmPassword = document.getElementById("confirmpassword");
            togglePasswordVisibility(confirmPassword, this);
        });
    }

    function togglePasswordVisibility(inputField, toggleIcon) {
        if (inputField.type === "password") {
            inputField.type = "text";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
        } else {
            inputField.type = "password";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
        }
    }

    // Password match validation
    document
        .getElementById("resetForm")
        .addEventListener("submit", function (e) {
            const newPassword = document.getElementById("newpassword").value;
            const confirmPassword =
                document.getElementById("confirmpassword").value;

            if (newPassword !== confirmPassword) {
                e.preventDefault();
                alert("Passwords do not match. Please try again.");
            }
        });
});
