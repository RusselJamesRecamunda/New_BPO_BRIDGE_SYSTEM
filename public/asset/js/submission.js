document.addEventListener("DOMContentLoaded", function () {
    const fileInputs = document.querySelectorAll(
        ".file-upload input[type='file']"
    );

    fileInputs.forEach((input) => {
        input.addEventListener("change", function () {
            const fileName =
                input.files.length > 0
                    ? input.files[0].name
                    : "No file selected";
            const parent = input.closest(".file-upload");
            parent.querySelector(
                "p"
            ).textContent = `Selected file: ${fileName}`;
        });
    });

    // Form submission event listener
    const form = document.getElementById("applicationForm");

    // Handle form submission
    form.addEventListener("submit", function (event) {
        event.preventDefault();

        Swal.fire({
            title: "Submitting your application...",
            text: "Please wait while we process your submission.",
            icon: "info",
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            timer: 2000,
        }).then(() => {
            // Submit the form programmatically after showing loading alert
            form.submit();
        });
    });

    // Display SweetAlert for success or error messages
    const successMessage = document.querySelector(
        "meta[name='success-message']"
    )?.content;
    const errorMessage = document.querySelector(
        "meta[name='error-message']"
    )?.content;

    if (successMessage) {
        Swal.fire({
            icon: "success",
            title: "Success",
            text: successMessage,
            confirmButtonText: "OK",
        });
    }

    if (errorMessage) {
        Swal.fire({
            icon: "error",
            title: "Submission Failed",
            text: errorMessage,
            confirmButtonText: "Retry",
        });
    }
});
