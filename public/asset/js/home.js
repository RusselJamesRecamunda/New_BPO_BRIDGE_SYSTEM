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

    // Ensure dropdown items handle clicks correctly
    document.querySelectorAll(".dropdown-item").forEach((item) => {
        item.addEventListener("click", function (event) {
            const link = item.getAttribute("href");

            if (link && link !== "#") {
                return; // Let the browser navigate
            }

            event.preventDefault();
            const dropdown = bootstrap.Dropdown.getInstance(dropdownButton);
            if (dropdown) {
                dropdown.hide(); // Close the dropdown
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
    const jobCards = document.querySelectorAll(".job-card");
    const jobCount = jobCards.length;
    const jobCountElement = document.getElementById("jobCount");
    if (jobCountElement) {
        jobCountElement.textContent = jobCount;
    }

    // Code for adding image to the search bar
    const searchBar = document.querySelector(".search-bar");
    if (searchBar) {
        const img = document.createElement("img");
        img.src = "/asset/img/catalog/home_catalog.png";
        img.alt = "Background";
        searchBar.appendChild(img);
    }

    // Code for truncating job descriptions by word count
    const jobDescriptions = document.querySelectorAll(".job-description");
    const maxWords = 20;

    jobDescriptions.forEach((jobDescription) => {
        // Get the raw HTML content of the job description
        const fullHTML = jobDescription.innerHTML;

        // Create a temporary element to handle HTML and extract plain text
        const tempDiv = document.createElement("div");
        tempDiv.innerHTML = fullHTML;

        // Extract text content and split it into words
        const textContent = tempDiv.textContent || tempDiv.innerText;
        const words = textContent.split(" ");

        // Truncate the text to the maxWords limit
        let truncatedText = words.slice(0, maxWords).join(" ");
        if (words.length > maxWords) {
            truncatedText += " ...";
        }

        // Rebuild the HTML structure, applying the truncation to the text content
        jobDescription.innerHTML = truncatedText;
    });
});
