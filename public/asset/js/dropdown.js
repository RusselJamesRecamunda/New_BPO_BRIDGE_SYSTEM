document.addEventListener("DOMContentLoaded", function () {
    // Ensure the dropdown button is correctly referenced
    const dropdownButton = document.querySelector("#profileDropdown");
    const dropdownIcon = dropdownButton.querySelector(".dropdown-icon");

    // Rotate the arrow when the dropdown is shown
    dropdownButton.addEventListener("show.bs.dropdown", function () {
        dropdownIcon.style.transform = "translateY(-50%) rotate(180deg)";
    });

    // Reset the arrow when the dropdown is hidden
    dropdownButton.addEventListener("hide.bs.dropdown", function () {
        dropdownIcon.style.transform = "translateY(-50%) rotate(0deg)";
    });

    // Close the dropdown and prevent navigation when an item is clicked
    document.querySelectorAll(".dropdown-item").forEach((item) => {
        item.addEventListener("click", function (event) {
            event.preventDefault(); // Prevent the page from navigating
            bootstrap.Dropdown.getInstance(dropdownButton).hide(); // Close dropdown

            // For sign-out, handle form submission
            if (item.textContent.trim() === "Sign out") {
                document.getElementById("logout-form").submit();
            }
        });
    });

    // Handle dropdown item clicks
    document.querySelectorAll(".dropdown-item").forEach((item) => {
        item.addEventListener("click", function (event) {
            const link = item.getAttribute("href");

            // Allow navigation if the href is valid and not "#"
            if (link && link !== "#") {
                return; // Let the browser handle the navigation
            }

            // Prevent default action for invalid or placeholder links
            event.preventDefault();
            if (dropdownButton) {
                bootstrap.Dropdown.getInstance(dropdownButton).hide(); // Close dropdown
            }
        });
    });

    // Updating dropdown buttons to reflect selected value
    document
        .querySelectorAll(".dropdown-menu a")
        .forEach(function (dropdownItem) {
            dropdownItem.addEventListener("click", function (e) {
                const button = e.target
                    .closest(".dropdown")
                    .querySelector(".dropdown-toggle");
                button.childNodes[0].textContent = e.target.textContent + " ";
                e.preventDefault();
            });
        });

    // Optional: Remove clicked state after a short delay
    document
        .querySelector(".search-bar .btn")
        .addEventListener("mouseup", function () {
            setTimeout(() => this.blur(), 100); // Remove focus after click for a smooth effect
        });

    // Count the number of job cards and update the job count in the heading
    const jobCards = document.querySelectorAll(".job-card");
    const jobCount = jobCards.length;
    document.getElementById("jobCount").textContent = jobCount;
});
