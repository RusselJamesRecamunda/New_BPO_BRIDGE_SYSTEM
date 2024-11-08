document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("login-form");
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");
    const emailWarning = document.getElementById("email-warning");
    const passwordWarning = document.getElementById("password-warning");

    emailInput.addEventListener("blur", function () {
        if (emailInput.value === "" || !emailInput.value.includes("@")) {
            emailWarning.style.visibility = "visible";
            emailInput.classList.add("error");
        } else {
            emailWarning.style.visibility = "hidden";
            emailInput.classList.remove("error");
        }
    });

    passwordInput.addEventListener("blur", function () {
        if (passwordInput.value === "") {
            passwordWarning.style.visibility = "visible";
            passwordInput.classList.add("error");
        } else {
            passwordWarning.style.visibility = "hidden";
            passwordInput.classList.remove("error");
        }
    });

    form.addEventListener("submit", function (event) {
        let valid = true;

        if (emailInput.value === "" || !emailInput.value.includes("@")) {
            emailWarning.style.visibility = "visible";
            emailInput.classList.add("error");
            valid = false;
        } else {
            emailWarning.style.visibility = "hidden";
            emailInput.classList.remove("error");
        }

        if (passwordInput.value === "") {
            passwordWarning.style.visibility = "visible";
            passwordInput.classList.add("error");
            valid = false;
        } else {
            passwordWarning.style.visibility = "hidden";
            passwordInput.classList.remove("error");
        }

        if (!valid) {
            event.preventDefault();
        }
    });
});

function togglePasswordVisibility() {
    const passwordInput = document.getElementById("password");
    const showPasswordIcon = document.getElementById("show-password");
    const hidePasswordIcon = document.getElementById("hide-password");

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        showPasswordIcon.style.display = "block";
        hidePasswordIcon.style.display = "none";
    } else {
        passwordInput.type = "password";
        showPasswordIcon.style.display = "none";
        hidePasswordIcon.style.display = "block";
    }
}
