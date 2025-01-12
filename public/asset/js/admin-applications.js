$(document).ready(function () {
    // Append the date range modal to the body
    $("body").append(`
        <div class="modal fade" id="dateRangeModal" tabindex="-1" aria-labelledby="dateRangeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="dateRangeModalLabel">Select Date Range</h5>
                        </div>
                    <div class="modal-body">
                        <form id="dateRangeForm">
                            <div class="mb-3">
                                <label for="startDate" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="startDate" name="startDate" required>
                            </div>
                            <div class="mb-3">
                                <label for="endDate" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="endDate" name="endDate" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="confirmDateRange"><i class="fa-regular fa-file-excel me-2 fs-5"></i>Export</button>
                    </div>
                </div>
            </div>
        </div>
    `);

    // Function to initialize DataTable for a given table
    function initializeDataTable(tableId) {
        $(tableId).DataTable({
            initComplete: function () {
                // Add Bootstrap styling to the DataTables search input
                const $searchInput = $(".dataTables_filter input")
                    .addClass("form-control") // Apply Bootstrap form control class
                    .attr("placeholder", "Search") // Add a placeholder to the input
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
                    const $magnifyingGlass = $(
                        ".search-container .search-icon"
                    );
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

    // Initialize both tables
    initializeDataTable("#applicant-table");
    initializeDataTable("#documents-table");

    $(document).on("click", ".export-button", function () {
        // Show the date range modal
        $("#dateRangeModal").modal("show");
    });

    // Handle the modal export confirmation
    $(document).on("click", "#confirmDateRange", function () {
        const startDate = $("#startDate").val();
        const endDate = $("#endDate").val();

        if (!startDate || !endDate) {
            Swal.fire({
                icon: "warning",
                title: "Invalid Date Range",
                text: "Please select both start and end dates.",
            });
            return;
        }

        // Trigger the export process with the selected date range
        $.ajax({
            url: exportUrl, // Ensure this URL points to the export route in your controller
            method: "GET",
            data: {
                start_date: startDate,
                end_date: endDate,
            },
            xhrFields: {
                responseType: "blob", // Ensure response is in binary format
            },
            success: function (response, status, xhr) {
                const disposition = xhr.getResponseHeader(
                    "Content-Disposition"
                );
                const fileNameMatch =
                    disposition && disposition.match(/filename="([^"]*)"/);
                const fileName =
                    fileNameMatch && fileNameMatch[1]
                        ? fileNameMatch[1]
                        : "exported_file.xlsx";

                const blob = response;
                const link = document.createElement("a");
                link.href = window.URL.createObjectURL(blob);
                link.download = fileName;
                link.click();

                // Hide the modal after successful export
                $("#dateRangeModal").modal("hide");
            },
            error: function (xhr) {
                Swal.fire({
                    icon: "error",
                    title: "Export Failed",
                    text:
                        xhr.responseJSON?.message ||
                        "An error occurred while exporting applications.",
                });
            },
        });
    });

    // Function to switch tabs and keep the export button in the active tab
    function showTab(tabName) {
        document.getElementById("applicant-info").style.display = "none";
        document.getElementById("documents").style.display = "none";
        document.getElementById(tabName).style.display = "block";

        var tabs = document.querySelectorAll(".custom-tab");
        tabs.forEach((tab) => {
            tab.classList.remove("active");
        });
        event.target.closest(".custom-tab").classList.add("active");

        if (tabName === "applicant-info") {
            $("#documents .dataTables_filter .export-buttons").remove();
            if (
                $("#applicant-info .dataTables_filter .export-buttons")
                    .length === 0
            ) {
                $("#applicant-info .dataTables_filter").append(`
                    <div class="export-buttons ms-auto">
                        <button class="export-button">
                            <i class="fa-solid fa-file-excel me-2"></i>Application Report
                        </button>
                    </div>
                `);
            }
        } else if (tabName === "documents") {
            $("#applicant-info .dataTables_filter .export-buttons").remove();
            if (
                $("#documents .dataTables_filter .export-buttons").length === 0
            ) {
                $("#documents .dataTables_filter").append(`
                    <div class="export-buttons ms-auto">
                        <button class="export-button">
                            <i class="fa-solid fa-file-excel me-2"></i>Application Report
                        </button>
                    </div>
                `);
            }
        }
    }

    if ($('.custom-tab[data-tab="applicant-info"]').hasClass("active")) {
        if (
            $("#applicant-info .dataTables_filter .export-buttons").length === 0
        ) {
            $("#applicant-info .dataTables_filter").append(`
                <div class="export-buttons ms-auto">
                    <button class="export-button">
                        <i class="fa-solid fa-file-excel me-2"></i>Application Report
                    </button>
                </div>
            `);
        }
    }

    $(".custom-tab").on("click", function (event) {
        var tabName = event.target.getAttribute("data-tab");
        showTab(tabName);
    });
});
