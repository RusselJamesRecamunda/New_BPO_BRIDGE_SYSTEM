// Function to initialize DataTable for a given table
function initializeDataTable(tableId) {
    $(tableId).DataTable({
        initComplete: function () {
            // Add Bootstrap styling to the DataTables search input
            const $searchInput = $(".dataTables_filter input")
                .addClass("form-control") // Apply Bootstrap form control class
                .attr("placeholder", " Search") // Add a placeholder to the input
                .css({
                    display: "flex",
                    width: "250px",
                    "background-color": "#f2f2f2",
                    "border-radius": "12px",
                    "box-shadow": "0 1px 5px rgba(0, 0, 0, 0.1)",
                    color: "#0c436d",
                    "font-weight": "600",
                    "padding-right": "35px", // Space for the cancel button
                    position: "relative",
                });

            // Wrap input field in a container for better positioning of the icons
            $searchInput.wrap(
                '<div class="search-container position-relative mt-2 mb-2"></div>'
            );

            // Add the magnifying glass icon to the right
            $(".search-container").append(
                '<i class="fa-solid fa-magnifying-glass position-absolute search-icon" style="right: 10px; top: 50%; transform: translateY(-50%); color: #0c436d;"></i>'
            );

            // Add the custom cancel button
            $(".search-container").append(
                '<i class="fa-solid fa-xmark position-absolute clear-search" style="right: 10px; top: 50%; transform: translateY(-50%); color: #0c436d; opacity: 0; cursor: pointer;"></i>'
            );

            // Add an event listener to toggle magnifying glass visibility based on input
            $searchInput.on("input", function () {
                const $magnifyingGlass = $(".search-container .search-icon");
                const $clearButton = $(".search-container .clear-search");

                if ($(this).val().length > 0) {
                    // Hide magnifying glass and show cancel button
                    $magnifyingGlass.css("opacity", "0");
                    $clearButton.css("opacity", "1");
                } else {
                    // Show magnifying glass and hide cancel button
                    $magnifyingGlass.css("opacity", "1");
                    $clearButton.css("opacity", "0");
                }
            });

            // Clear the search input when the cancel button is clicked
            $(".search-container .clear-search").on("click", function () {
                $searchInput.val("").trigger("input"); // Clear the input and trigger the event to reset icons
            });

            // Hide the native cancel button provided by DataTables
            const style = document.createElement("style");
            style.textContent = `
                .dataTables_filter input::-webkit-search-cancel-button {
                    display: none; /* Hide the native cancel button */
                }
            `;
            document.head.appendChild(style);

            // Remove the "Search:" label
            $(".dataTables_filter label")
                .contents()
                .filter(function () {
                    return this.nodeType === 3; // Node type 3 is text nodes
                })
                .remove();
        },
    });
}

document.addEventListener("DOMContentLoaded", function () {
    // Initialize DataTables with custom search functionality for Candidates table
    initializeDataTable("#candidates table");

    // Initialize DataTables with custom search functionality for Documents table
    initializeDataTable("#documents table");

    // Parse the data from the single script tag
    const chartData = JSON.parse(
        document.getElementById("chartData").textContent
    );
    const daysOfWeek = chartData.daysOfWeek;
    let applicantData = chartData.applicantData;

    // Ensure that only 7 data points are included in the chart
    applicantData = applicantData.slice(0, 7);

    // Chart.js Integration
    const ctx = document.getElementById("clickChart").getContext("2d");
    const clickChart = new Chart(ctx, {
        type: "line",
        data: {
            labels: daysOfWeek, // Days of the week
            datasets: [
                {
                    label: "Applicants",
                    data: applicantData, // Dynamic applicant data
                    backgroundColor: "rgba(124, 58, 237, 0.2)",
                    borderColor: "#7C3AED",
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                },
            ],
        },
        options: {
            plugins: {
                legend: { display: false },
            },
            scales: {
                y: { beginAtZero: true },
            },
        },
    });
    // Select all buttons with the specified classes
    document
        .querySelectorAll(".btn-outline-success, .btn-outline-danger")
        .forEach((button) => {
            button.addEventListener("click", function () {
                const applicationId = this.getAttribute("data-id"); // Get the application ID
                const status = this.getAttribute("data-status"); // Get the status from the button's data attribute

                // Send an AJAX request to the controller
                fetch(overviewJobStoreRoute, {
                    // overviewJobStoreRoute is defined in the Blade template
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken, // csrfToken is defined in the Blade template
                    },
                    body: JSON.stringify({
                        application_id: applicationId,
                        status: status,
                    }),
                })
                    .then((response) => {
                        if (!response.ok) {
                            // Handle errors by parsing the response JSON
                            return response.json().then((error) => {
                                throw new Error(
                                    error.error || "An error occurred"
                                );
                            });
                        }
                        return response.json();
                    })
                    .then((data) => {
                        // Show success alert with SweetAlert
                        Swal.fire({
                            icon: "success",
                            title: "Success",
                            text: data.message,
                            confirmButtonText: "OK",
                        });
                    })
                    .catch((error) => {
                        console.error("Error:", error.message);
                        // Show error alert with SweetAlert
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text:
                                error.message ||
                                "Failed to update candidate status. Please try again.",
                            confirmButtonText: "OK",
                        });
                    });
            });
        });
});

// Function to show the selected tab
function showTab(tabName) {
    // Hide all tabs
    document.getElementById("job-info").style.display = "none";
    document.getElementById("candidates").style.display = "none";
    document.getElementById("documents").style.display = "none";

    // Show the selected tab
    document.getElementById(tabName).style.display = "block";

    // Update active tab
    const tabs = document.querySelectorAll(".custom-tab");
    tabs.forEach((tab) => {
        tab.classList.remove("active");
    });
    event.target.closest(".custom-tab").classList.add("active");
}
