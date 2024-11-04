// user-search.js
$(document).ready(function () {
    // Function to update status color and AJAX request for status change
    function initStatusSelects() {
        $("#user-management-section .status-select").each(function () {
            updateStatusColor(this);

            $(this).on("change", function () {
                updateStatusColor(this);

                // Send AJAX request to update status in the backend
                const status = $(this).val();
                const userId = $(this).data("id");

                fetch(`/update-status/${userId}`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken, // Use a variable for CSRF token
                    },
                    body: JSON.stringify({ status: status }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            alert("Status updated successfully");
                        } else {
                            alert("Failed to update status");
                        }
                    })
                    .catch((error) => {
                        console.error("Error:", error);
                    });
            });
        });
    }

    // Function to change the background color of the select based on the selected option
    function updateStatusColor(selectElement) {
        const selectedOption =
            selectElement.options[selectElement.selectedIndex];
        const classList = selectedOption.className;
        selectElement.className = "status-select " + classList;
    }

    // Function to perform the search
    function performSearch() {
        let query = $(".custom-search-bar input").val();
        let url = searchUrl + encodeURIComponent(query); // Use a variable for the search URL

        fetch(url, {
            headers: {
                "X-Requested-With": "XMLHttpRequest",
            },
        })
            .then((response) => response.json())
            .then((data) => {
                if (data.message) {
                    alert(data.message); // Show alert if no results found
                } else {
                    const content = $(data.html)
                        .find("#user-management-section")
                        .html();
                    $("#user-management-section").html(content);
                    // Reinitialize the status select event listeners
                    initStatusSelects();
                }
            })
            .catch((error) => console.error("Error:", error));
    }

    // Listen for click event on the search button
    $(".custom-search-bar button").on("click", function () {
        performSearch();
    });

    // Listen for Enter key press in the input field
    $(".custom-search-bar input").on("keypress", function (e) {
        if (e.key === "Enter") {
            e.preventDefault(); // Prevent the form from submitting (if within a form)
            performSearch();
        }
    });

    // Initialize status selects on page load
    initStatusSelects();
});
