document.addEventListener("DOMContentLoaded", function () {
    const dropdownButton = document.querySelector(".dropdown-toggle");

    if (dropdownButton) {
        const dropdownIcon = dropdownButton.querySelector(".dropdown-icon");

        // Rotate the arrow when the dropdown is shown
        dropdownButton.addEventListener("show.bs.dropdown", function () {
            if (dropdownIcon) {
                dropdownIcon.style.transform =
                    "translateY(-50%) rotate(180deg)";
            }
        });

        // Reset the arrow when the dropdown is hidden
        dropdownButton.addEventListener("hide.bs.dropdown", function () {
            if (dropdownIcon) {
                dropdownIcon.style.transform = "translateY(-50%) rotate(0deg)";
            }
        });
    }

    // Close the dropdown when an item is clicked
    document.querySelectorAll(".dropdown-item").forEach((item) => {
        item.addEventListener("click", function (event) {
            event.preventDefault(); // Prevent the page from jumping
            if (dropdownButton) {
                bootstrap.Dropdown.getInstance(dropdownButton).hide(); // Close dropdown
            }
        });
    });
});

// Updating dropdown buttons to reflect selected value
document.querySelectorAll(".dropdown-menu a").forEach(function (dropdownItem) {
    dropdownItem.addEventListener("click", function (e) {
        const button = e.target
            .closest(".dropdown")
            ?.querySelector(".dropdown-toggle");
        if (button) {
            button.childNodes[0].textContent = e.target.textContent + " ";
            e.preventDefault();
        }
    });
});

// Optional: Remove clicked state after a short delay
const searchButton = document.querySelector(".search-bar .btn");
if (searchButton) {
    searchButton.addEventListener("mouseup", function () {
        setTimeout(() => this.blur(), 100); // Remove focus after click for a smooth effect
    });
}

// Count the number of job cards and update the job count in the heading
document.addEventListener("DOMContentLoaded", function () {
    const jobCards = document.querySelectorAll(".job-card");
    const jobCount = jobCards.length;
    const jobCountElement = document.getElementById("jobCount");
    if (jobCountElement) {
        jobCountElement.textContent = jobCount;
    }
});
