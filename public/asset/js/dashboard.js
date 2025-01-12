document.addEventListener("DOMContentLoaded", function () {
    var setChartHeight = function (chartId, height) {
        var canvas = document.getElementById(chartId);
        canvas.style.height = height + "px"; // Set fixed height
        canvas.style.width = "100%"; // Ensure full width
    };

    // Line chart for Vacancy Stats
    var ctx = document.getElementById("vacancyStatsChart").getContext("2d");
    setChartHeight("vacancyStatsChart", 300); // Set height to 300px

    var vacancyStatsChart = new Chart(ctx, {
        type: "line", // Line chart
        data: {
            labels: ["Week 1", "Week 2", "Week 3", "Week 4"],
            datasets: [
                {
                    label: "Application Sent",
                    borderColor: "#377dff",
                    backgroundColor: "rgba(55, 125, 255, 0.2)",
                    data: [30, 49, 52, 94],
                    fill: true,
                    tension: 0.4,
                },
                {
                    label: "Interviews",
                    borderColor: "#54ca76",
                    backgroundColor: "rgba(84, 202, 118, 0.2)",
                    data: [2, 24, 60, 76],
                    fill: true,
                    tension: 0.4,
                },
                {
                    label: "Rejected",
                    borderColor: "#f379e2",
                    backgroundColor: "rgba(243, 121, 226, 0.2)",
                    data: [5, 30, 25, 60],
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
                },
            },
        },
    });

    // Donut chart options
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
