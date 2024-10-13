// Profile picture preview
document
    .getElementById("profile-pic-upload")
    .addEventListener("change", function (event) {
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function (e) {
            document.getElementById("profile-img").src = e.target.result;
        };

        reader.readAsDataURL(file);
    });

// Function to validate required fields
function validateRequiredFields(containerId) {
    const requiredFields = document.querySelectorAll(
        `#${containerId} [required]`
    );
    for (const field of requiredFields) {
        if (!field.value) {
            field.classList.add("is-invalid"); // Add Bootstrap's invalid class
            return false; // Return false if any required field is empty
        } else {
            field.classList.remove("is-invalid"); // Remove invalid class if filled
        }
    }
    return true; // All required fields are filled
}

// Function to switch tabs
function switchTab(currentTab, nextTab) {
    // Hide current tab content
    document.getElementById(currentTab).style.display = "none";
    // Show next tab content
    document.getElementById(nextTab).style.display = "block";

    // Update active tab class
    const tabs = document.querySelectorAll(".custom-tab");
    tabs.forEach((tab) => {
        // Check if the tab's target matches the next tab
        if (tab.dataset.target === `#${nextTab}`) {
            tab.classList.add("active"); // Add active class to the active tab
        } else {
            tab.classList.remove("active"); // Remove active class from other tabs
        }
    });
}

// Navigation buttons click events
document.getElementById("next-btn-1").addEventListener("click", function () {
    if (validateRequiredFields("personal-info")) {
        switchTab("personal-info", "professional-info");
    }
});

document.getElementById("next-btn-2").addEventListener("click", function () {
    if (validateRequiredFields("professional-info")) {
        switchTab("professional-info", "document-info");
    }
});

// Back button click events
document.getElementById("back-btn-1").addEventListener("click", function () {
    switchTab("professional-info", "personal-info");
});

document.getElementById("back-btn-2").addEventListener("click", function () {
    switchTab("document-info", "professional-info");
});

// Cancel button to clear the form fields
document.getElementById("cancel-btn-1").addEventListener("click", function () {
    document.querySelectorAll("input, select").forEach((field) => {
        if (["text", "email", "date", "file"].includes(field.type)) {
            field.value = ""; // Clear text, email, date, and file inputs
        } else if (field.tagName.toLowerCase() === "select") {
            field.selectedIndex = 0; // Reset select fields to the first option
        }
    });
});

// Update file input label with selected file name
const fileInputs = document.querySelectorAll(".file-input");
fileInputs.forEach((input) => {
    input.addEventListener("change", function () {
        const fileName = this.files[0]?.name || "choose file";
        const label = this.closest(".mb-4").querySelector(".file-label");
        label.innerHTML = `File selected: <span class="text-primary">${fileName}</span>`;
    });
});
