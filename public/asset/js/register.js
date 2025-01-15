document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("register-form");
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");
    const confirmPasswordInput = document.getElementById(
        "password_confirmation"
    );
    const checkbox = document.getElementById("agree-checkbox");

    const emailWarning = document.getElementById("email-warning");
    const passwordValidationWarning = document.getElementById(
        "password-validation-warning"
    );
    const confirmPasswordWarning = document.getElementById(
        "confirm-password-warning"
    );
    const checkboxWarning = document.getElementById("checkbox-warning");

    // Helper function for password validation
    function isValidPassword(password) {
        const regex =
            /^(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*_(),.?":{}|<>])[A-Za-z\d!@#$%^&*_(),.?":{}|<>]{12,}$/;
        return regex.test(password);
    }

    // Email validation
    emailInput.addEventListener("blur", function () {
        if (emailInput.value === "" || !emailInput.value.includes("@")) {
            emailWarning.style.display = "block";
            emailInput.classList.add("error");
        } else {
            emailWarning.style.display = "none";
            emailInput.classList.remove("error");
        }
    });

    // Password validation
    passwordInput.addEventListener("input", function () {
        if (!isValidPassword(passwordInput.value)) {
            passwordValidationWarning.style.display = "block";
            passwordInput.classList.add("error");
        } else {
            passwordValidationWarning.style.display = "none";
            passwordInput.classList.remove("error");
        }
    });

    // Confirm password validation
    confirmPasswordInput.addEventListener("input", function () {
        if (confirmPasswordInput.value !== passwordInput.value) {
            confirmPasswordWarning.style.display = "block";
            confirmPasswordInput.classList.add("error");
        } else {
            confirmPasswordWarning.style.display = "none";
            confirmPasswordInput.classList.remove("error");
        }
    });

    // Checkbox validation
    checkbox.addEventListener("change", function () {
        if (!checkbox.checked) {
            checkboxWarning.style.display = "block";
            checkbox.classList.add("error");
        } else {
            checkboxWarning.style.display = "none";
            checkbox.classList.remove("error");
        }
    });

    // Form submission validation
    form.addEventListener("submit", function (event) {
        let valid = true;

        if (emailInput.value === "" || !emailInput.value.includes("@")) {
            emailWarning.style.display = "block";
            emailInput.classList.add("error");
            valid = false;
        } else {
            emailWarning.style.display = "none";
            emailInput.classList.remove("error");
        }

        if (!isValidPassword(passwordInput.value)) {
            passwordValidationWarning.style.display = "block";
            passwordInput.classList.add("error");
            valid = false;
        } else {
            passwordValidationWarning.style.display = "none";
            passwordInput.classList.remove("error");
        }

        if (confirmPasswordInput.value !== passwordInput.value) {
            confirmPasswordWarning.style.display = "block";
            confirmPasswordInput.classList.add("error");
            valid = false;
        } else {
            confirmPasswordWarning.style.display = "none";
            confirmPasswordInput.classList.remove("error");
        }

        if (!checkbox.checked) {
            checkboxWarning.style.display = "block";
            checkbox.classList.add("error");
            valid = false;
        } else {
            checkboxWarning.style.display = "none";
            checkbox.classList.remove("error");
        }

        if (!valid) {
            event.preventDefault();
        }
    });
});

// Function to toggle password visibility
function togglePasswordVisibility(id) {
    const passwordInput = document.getElementById(id);
    const showPasswordIcon =
        passwordInput.nextElementSibling.querySelector(".show-password");
    const hidePasswordIcon =
        passwordInput.nextElementSibling.querySelector(".hide-password");

    if (passwordInput.type === "password") {
        passwordInput.type = "text"; // Show password
        showPasswordIcon.style.display = "inline"; // Show 'eye' icon
        hidePasswordIcon.style.display = "none"; // Hide 'eye-slash' icon
    } else {
        passwordInput.type = "password"; // Hide password
        showPasswordIcon.style.display = "none"; // Hide 'eye' icon
        hidePasswordIcon.style.display = "inline"; // Show 'eye-slash' icon
    }
}
