document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("register-form");
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");
    const confirmPasswordInput = document.getElementById(
        "password_confirmation"
    );
    const checkbox = document.getElementById("agree-checkbox");
    const emailWarning = document.getElementById("email-warning");
    const passwordWarning = document.getElementById("password-warning");
    const confirmPasswordWarning = document.getElementById(
        "confirm-password-warning"
    );
    const checkboxWarning = document.getElementById("checkbox-warning");

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
    passwordInput.addEventListener("blur", function () {
        if (passwordInput.value === "") {
            passwordWarning.style.display = "block";
            passwordInput.classList.add("error");
        } else {
            passwordWarning.style.display = "none";
            passwordInput.classList.remove("error");
        }
    });

    // Confirm password validation
    confirmPasswordInput.addEventListener("blur", function () {
        if (
            confirmPasswordInput.value !== passwordInput.value ||
            confirmPasswordInput.value === ""
        ) {
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

        if (passwordInput.value === "") {
            passwordWarning.style.display = "block";
            passwordInput.classList.add("error");
            valid = false;
        } else {
            passwordWarning.style.display = "none";
            passwordInput.classList.remove("error");
        }

        if (
            confirmPasswordInput.value !== passwordInput.value ||
            confirmPasswordInput.value === ""
        ) {
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
        showPasswordIcon.style.display = "none"; // Hide show icon
        hidePasswordIcon.style.display = "inline"; // Show hide icon
    } else {
        passwordInput.type = "password"; // Hide password
        showPasswordIcon.style.display = "inline"; // Show show icon
        hidePasswordIcon.style.display = "none"; // Hide hide icon
    }
}
