document.addEventListener("DOMContentLoaded", function () {
    // Get the 'tab' query parameter from the URL
    const urlParams = new URLSearchParams(window.location.search);
    const activeTab = urlParams.get("tab") || "saved"; // Default to 'saved' if no 'tab' is set in the URL

    // Call the showSection function with the activeTab value (either 'saved' or 'applied')
    showSection(activeTab);

    const deleteModal = document.getElementById("deleteModal");
    const confirmDeleteButton = document.getElementById("confirmDeleteButton");
    let selectedSaveID = null;

    // When the modal is shown, get the save_ID from the clicked delete button
    deleteModal.addEventListener("show.bs.modal", function (event) {
        const button = event.relatedTarget; // Button that triggered the modal
        selectedSaveID = button.getAttribute("data-save-id"); // Extract info from data-* attributes
    });

    // Handle delete confirmation
    confirmDeleteButton.addEventListener("click", function () {
        if (selectedSaveID) {
            const deleteUrl = `${window.applicantUrls.deleteUrl}/${selectedSaveID}`; // Use the dynamic delete URL
            const csrfToken = document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"); // Get CSRF token from meta tag

            fetch(deleteUrl, {
                method: "DELETE",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": csrfToken, // Apply the CSRF token
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.success) {
                        alert(data.message); // Show success message
                        location.reload(); // Reload the page to reflect changes
                    } else {
                        alert(data.message); // Show error message
                    }
                })
                .catch((error) => {
                    console.error("Error:", error);
                    alert(
                        "An error occurred while deleting the job. Please try again later."
                    );
                });
        }
    });
});

// Function to show the appropriate section based on the active tab
function showSection(section) {
    const savedTab = document.getElementById("savedTab");
    const appliedTab = document.getElementById("appliedTab");
    const savedJobs = document.getElementById("savedJobs");
    const appliedJobs = document.getElementById("appliedJobs");
    const sectionHeader = document.getElementById("sectionHeader");

    // Remove active class from tabs and sections
    savedTab.classList.remove("active");
    appliedTab.classList.remove("active");
    savedJobs.classList.remove("active");
    appliedJobs.classList.remove("active");

    // Add active class to the selected tab and section
    if (section === "saved") {
        savedTab.classList.add("active");
        savedJobs.classList.add("active");
        sectionHeader.textContent = "Saved Jobs"; // Update header
    } else if (section === "applied") {
        appliedTab.classList.add("active");
        appliedJobs.classList.add("active");
        sectionHeader.textContent = "Applied Jobs"; // Update header
    }
}
