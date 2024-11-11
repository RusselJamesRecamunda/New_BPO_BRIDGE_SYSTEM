document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");

    // Field elements
    const firstNameInput = document.getElementById("firstName");
    const lastNameInput = document.getElementById("lastName");
    const emailInput = document.getElementById("email");
    const phoneInput = document.getElementById("phone");
    const locationInput = document.getElementById("location");
    const resumeInput = document.getElementById("resume");
    const calendarInput = document.getElementById("startDate");

    // Error message elements
    const firstNameError = document.getElementById("firstNameError");
    const lastNameError = document.getElementById("lastNameError");
    const emailError = document.getElementById("emailError");
    const phoneError = document.getElementById("phoneError");
    const locationError = document.getElementById("locationError");
    const calendarError = document.getElementById("calendarError");

    // Helper function to show or hide error messages
    function showError(input, errorElement, message) {
        if (message) {
            errorElement.textContent = message;
            errorElement.style.display = "block"; // Show error message
            input.classList.add("error");
        } else {
            errorElement.style.display = "none"; // Hide error message
            input.classList.remove("error");
        }
    }

    // Event listeners for "blur" events to show error if the input is empty or invalid
    firstNameInput.addEventListener("blur", function () {
        showError(
            firstNameInput,
            firstNameError,
            firstNameInput.value === "" ? "First Name cannot be empty." : ""
        );
    });

    lastNameInput.addEventListener("blur", function () {
        showError(
            lastNameInput,
            lastNameError,
            lastNameInput.value === "" ? "Last Name cannot be empty." : ""
        );
    });

    emailInput.addEventListener("blur", function () {
        const emailValue = emailInput.value;
        const isValidEmail = emailValue.includes("@");
        showError(
            emailInput,
            emailError,
            emailValue === ""
                ? "Email cannot be empty."
                : !isValidEmail
                ? "Invalid email format."
                : ""
        );
    });

    phoneInput.addEventListener("blur", function () {
        const phoneValue = phoneInput.value;
        const isValidPhone = /^\+?[0-9]+$/.test(phoneValue);
        showError(
            phoneInput,
            phoneError,
            phoneValue === ""
                ? "Phone cannot be empty."
                : !isValidPhone
                ? "Phone must contain only numbers and may start with +."
                : ""
        );
    });

    locationInput.addEventListener("blur", function () {
        showError(
            locationInput,
            locationError,
            locationInput.value === "" ? "Field cannot be empty." : ""
        );
    });

    resumeInput.addEventListener("change", function () {
        showError(
            resumeInput,
            locationError,
            resumeInput.files.length === 0 ? "Resume cannot be empty." : ""
        );
    });

    // Event listener for calendar input validation
    calendarInput.addEventListener("blur", function () {
        showError(
            calendarInput,
            calendarError,
            calendarInput.value === "" ? "Field cannot be empty." : ""
        );
    });

    // Form submission validation
    form.addEventListener("submit", function (event) {
        let valid = true;

        if (firstNameInput.value === "") {
            showError(
                firstNameInput,
                firstNameError,
                "First Name cannot be empty."
            );
            valid = false;
        }
        if (lastNameInput.value === "") {
            showError(
                lastNameInput,
                lastNameError,
                "Last Name cannot be empty."
            );
            valid = false;
        }
        if (emailInput.value === "" || !emailInput.value.includes("@")) {
            showError(
                emailInput,
                emailError,
                emailInput.value === ""
                    ? "Email cannot be empty."
                    : "Invalid email format."
            );
            valid = false;
        }
        if (phoneInput.value === "" || !/^\+?[0-9]+$/.test(phoneInput.value)) {
            showError(
                phoneInput,
                phoneError,
                phoneInput.value === ""
                    ? "Phone cannot be empty."
                    : "Phone must contain only numbers and may start with +."
            );
            valid = false;
        }
        if (locationInput.value === "") {
            showError(locationInput, locationError, "Field cannot be empty.");
            valid = false;
        }
        if (resumeInput.files.length === 0) {
            showError(resumeInput, locationError, "Resume cannot be empty.");
            valid = false;
        }
        if (calendarInput.value === "") {
            showError(calendarInput, calendarError, "Field cannot be empty.");
            valid = false;
        }

        if (!valid) {
            event.preventDefault(); // Prevent form submission if there are errors
        } else {
            event.preventDefault(); // Prevent the actual form submission to display the modal
            showConfirmationModal(); // Show the modal confirmation
        }
    });

    // Confirmation modal display function
    function showConfirmationModal() {
        const modalHtml = `
            <div id="confirmationModal" class="modal" style="display: flex; align-items: center; justify-content: center; background: rgba(0,0,0,0.5); position: fixed; top: 0; left: 0; width: 100%; height: 100%;">
                <div class="modal-content" style="background: white; padding: 20px; border-radius: 8px; text-align: center;">
                    <p>Thank you for applying, please wait for our email for further information.</p>
                    <button id="modalOkButton" class="btn btn-primary">OK</button>
                </div>
            </div>`;

        document.body.insertAdjacentHTML("beforeend", modalHtml);

        const modalOkButton = document.getElementById("modalOkButton");
        modalOkButton.addEventListener("click", function () {
            document.getElementById("confirmationModal").remove(); // Close modal
            form.reset(); // Reset the form after confirmation
        });
    }

    // Reset form and hide error messages
    form.addEventListener("reset", function () {
        showError(firstNameInput, firstNameError, "");
        showError(lastNameInput, lastNameError, "");
        showError(emailInput, emailError, "");
        showError(phoneInput, phoneError, "");
        showError(locationInput, locationError, "");
        showError(resumeInput, locationError, "");
        showError(calendarInput, calendarError, "");
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const resumeInput = document.getElementById("resume");
    const coverLetterInput = document.getElementById("coverLetter");
    const resumeFileNameDisplay = document.getElementById("resumeFileName");
    const coverLetterFileNameDisplay = document.getElementById(
        "coverLetterFileName"
    );

    // Event listener to update file name display for resume
    resumeInput.addEventListener("change", function () {
        const fileName = resumeInput.files[0] ? resumeInput.files[0].name : "";
        resumeFileNameDisplay.textContent = fileName;
    });

    // Event listener to update file name display for cover letter
    coverLetterInput.addEventListener("change", function () {
        const fileName = coverLetterInput.files[0]
            ? coverLetterInput.files[0].name
            : "";
        coverLetterFileNameDisplay.textContent = fileName;
    });
});
