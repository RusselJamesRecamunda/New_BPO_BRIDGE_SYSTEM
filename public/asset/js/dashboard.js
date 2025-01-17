document.addEventListener("DOMContentLoaded", function () {
    var setChartHeight = function (chartId, height) {
        var canvas = document.getElementById(chartId);
        canvas.style.height = height + "px"; // Set fixed height
        canvas.style.width = "100%"; // Ensure full width
    };

    // Get the data from the canvas element's data attributes
    var canvas = document.getElementById("vacancyStatsChart");
    var pendingApplicationsData = JSON.parse(
        canvas.getAttribute("data-pending")
    );
    var scheduledInterviewsData = JSON.parse(
        canvas.getAttribute("data-scheduled")
    );
    var rejectedApplicationsData = JSON.parse(
        canvas.getAttribute("data-rejected")
    );

    // Line chart for Vacancy Stats
    var ctx = document.getElementById("vacancyStatsChart").getContext("2d");
    setChartHeight("vacancyStatsChart", 300); // Set height to 300px

    var vacancyStatsChart = new Chart(ctx, {
        type: "line", // Line chart
        data: {
            labels: ["Week 1", "Week 2", "Week 3", "Week 4"],
            datasets: [
                {
                    label: "Pending Applications",
                    borderColor: "#377dff",
                    backgroundColor: "rgba(55, 125, 255, 0.2)",
                    data: pendingApplicationsData, // Data for Pending Applications
                    fill: true,
                    tension: 0.4,
                },
                {
                    label: "Scheduled Interviews",
                    borderColor: "#54ca76",
                    backgroundColor: "rgba(84, 202, 118, 0.2)",
                    data: scheduledInterviewsData, // Data for Scheduled Interviews
                    fill: true,
                    tension: 0.4,
                },
                {
                    label: "Rejected Applications",
                    borderColor: "#f379e2",
                    backgroundColor: "rgba(243, 121, 226, 0.2)",
                    data: rejectedApplicationsData, // Data for Rejected Applications
                    fill: true,
                    tension: 0.4,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: "top",
                },
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: "Weeks",
                    },
                },
                y: {
                    title: {
                        display: true,
                        text: "Counts",
                    },
                    beginAtZero: true, // Ensure the Y-axis starts from 0
                },
            },
        },
    });

    // Display current month and year on the button
    var currentMonthYear = document.getElementById("currentMonthYear");
    var now = new Date();
    var monthNames = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
    ];
    var currentMonth = monthNames[now.getMonth()]; // Get the current month
    var currentYear = now.getFullYear(); // Get the current year
    currentMonthYear.textContent = currentMonth + " " + currentYear; // Display the month and year in the button

    // SweetAlert for selecting month
    document
        .getElementById("monthYearButton")
        .addEventListener("click", function () {
            Swal.fire({
                title: "Select a Month",
                input: "select",
                inputOptions: monthNames.reduce((acc, month, index) => {
                    acc[index] = month; // Add months as options
                    return acc;
                }, {}),
                inputPlaceholder: "Select a month",
                showCancelButton: true,
                confirmButtonText: "Show Data",
                cancelButtonText: "Cancel",
                preConfirm: (selectedMonthIndex) => {
                    // Handle the selected month
                    if (selectedMonthIndex === null) {
                        return;
                    }

                    var selectedMonth = monthNames[selectedMonthIndex];
                    var selectedYear = now.getFullYear(); // You can also select year if needed

                    // Update the chart with new data for the selected month
                    var selectedMonthData = getDataForMonth(selectedMonthIndex);

                    if (selectedMonthData) {
                        updateChartData(selectedMonthData);
                        currentMonthYear.textContent =
                            selectedMonth + " " + selectedYear;
                    } else {
                        Swal.fire({
                            icon: "info",
                            title: "No Data",
                            text:
                                "There is no data yet for " +
                                selectedMonth +
                                " " +
                                selectedYear +
                                ".",
                        });
                    }
                },
            });
        });

    // Function to get data for a selected month
    function getDataForMonth(monthIndex) {
        // Here, you would need to implement logic to get data for the selected month.
        // This is just a placeholder to simulate fetching data for the selected month.
        // Example: You could fetch from an API or use your backend to return data for that month.

        // For now, return the data based on the month index (just for illustration)
        if (monthIndex === new Date().getMonth()) {
            return {
                pendingApplications: pendingApplicationsData,
                scheduledInterviews: scheduledInterviewsData,
                rejectedApplications: rejectedApplicationsData,
            };
        } else {
            return null; // No data for this month
        }
    }

    // Function to update the chart with new data
    function updateChartData(monthData) {
        vacancyStatsChart.data.datasets[0].data = monthData.pendingApplications;
        vacancyStatsChart.data.datasets[1].data = monthData.scheduledInterviews;
        vacancyStatsChart.data.datasets[2].data =
            monthData.rejectedApplications;
        vacancyStatsChart.update();
    }

    // Donut chart options (same as before)
    var donutOptions = {
        type: "doughnut",
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: "75%",
            plugins: {
                tooltip: { enabled: false },
                legend: { display: false },
            },
            elements: {
                arc: {
                    borderWidth: 0,
                },
            },
        },
    };

    // Donut chart for Available Jobs
    var availableJobsCtx = document
        .getElementById("availableJobsChart")
        .getContext("2d");
    setChartHeight("availableJobsChart", 250); // Set height to 250px
    new Chart(availableJobsCtx, {
        ...donutOptions,
        data: {
            datasets: [
                {
                    data: [86, 14],
                    backgroundColor: ["#FFA726", "#E0E0E0"],
                },
            ],
        },
    });

    // Donut chart for Open Jobs
    var openJobsCtx = document.getElementById("openJobsChart").getContext("2d");
    setChartHeight("openJobsChart", 250); // Set height to 250px
    new Chart(openJobsCtx, {
        ...donutOptions,
        data: {
            datasets: [
                {
                    data: [64, 36],
                    backgroundColor: ["#66BB6A", "#E0E0E0"],
                },
            ],
        },
    });

    // Donut chart for Closed Jobs
    var closedJobsCtx = document
        .getElementById("closedJobsChart")
        .getContext("2d");
    setChartHeight("closedJobsChart", 250); // Set height to 250px
    new Chart(closedJobsCtx, {
        ...donutOptions,
        data: {
            datasets: [
                {
                    data: [33, 67],
                    backgroundColor: ["#EF5350", "#E0E0E0"],
                },
            ],
        },
    });
});
