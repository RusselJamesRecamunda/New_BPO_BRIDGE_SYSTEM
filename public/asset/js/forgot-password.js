document
    .getElementById("resetForm")
    .addEventListener("submit", function (event) {
        event.preventDefault();
        let email = document.getElementById("email");
        let errorMessage = document.getElementById("error-message");

        if (email.value === "") {
            // Show error message and make the border re d
            email.classList.add("is-invalid");
            errorMessage.classList.remove("d-none");
        } else {
            // Reset error message if input is valid
            email.classList.remove("is-invalid");
            errorMessage.classList.add("d-none");
            alert("OTP sent to your email!");
            // Additional logic for OTP sending can be implemented here
        }
    });
