document
    .getElementById("resetForm")
    .addEventListener("submit", function (event) {
        let email = document.getElementById("email");
        let errorMessage = document.getElementById("error-message");

        if (email.value === "") {
            // Show error message and make the border red
            email.classList.add("is-invalid");
            errorMessage.classList.remove("d-none");
            event.preventDefault(); // Prevent form submission if the email is empty
        } else {
            // Reset error message if input is valid
            email.classList.remove("is-invalid");
            errorMessage.classList.add("d-none");
            // Allow form submission
            // Optionally show a loading message or spinner
        }
    });
