document.addEventListener("DOMContentLoaded", () => {
    const sidebar = document.getElementById("sidebar");
    const sidebarCollapseButton = document.getElementById("sidebarCollapse");

    // Toggle sidebar collapse/expand
    sidebarCollapseButton.addEventListener("click", () => {
        sidebar.classList.toggle("active");
    });

    // Function to navigate to a given URL
    function navigateTo(url) {
        window.location.href = url;
    }

    // Add event listener for each button inside the dropdown
    document.querySelectorAll(".dropdown-item").forEach((item) => {
        item.addEventListener("click", (event) => {
            const url = event.target.getAttribute("data-url");
            if (url) {
                navigateTo(url); // Call navigateTo only when a button in the dropdown is clicked
            }
        });
    });
});
