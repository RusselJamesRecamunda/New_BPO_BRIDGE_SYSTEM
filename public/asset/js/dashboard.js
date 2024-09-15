document.addEventListener("DOMContentLoaded", function () {
    var setChartHeight = function (chartId, height) {
        var canvas = document.getElementById(chartId);
        canvas.style.height = height + "px"; // Set fixed height
        canvas.style.width = "100%"; // Ensure full width
    };

    var ctx = document.getElementById("vacancyStatsChart").getContext("2d");
    setChartHeight("vacancyStatsChart", 300); // Set height to 300px, adjust as needed

    var vacancyStatsChart = new Chart(ctx, {
        type: "bar",
        data: {
            labels: [
                "Week 1",
                "Week 2",
                "Week 3",
                "Week 4",
                "Week 5",
                "Week 6",
                "Week 7",
                "Week 8",
                "Week 9",
                "Week 10",
            ],
            datasets: [
                {
                    label: "Application Sent",
                    backgroundColor: "#377dff",
                    data: [20, 30, 40, 50, 60, 70, 80, 90, 100, 110],
                },
                {
                    label: "Interviews",
                    backgroundColor: "#54ca76",
                    data: [10, 20, 30, 40, 50, 60, 70, 80, 90, 100],
                },
                {
                    label: "Rejected",
                    backgroundColor: "#f379e2",
                    data: [5, 10, 15, 20, 25, 30, 35, 40, 45, 50],
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false, // Allow custom height
            plugins: {
                legend: {
                    position: "top",
                },
            },
        },
    });

    var donutOptions = {
        type: "doughnut",
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: "75%",
            plugins: {
                tooltip: { enabled: false },
                legend: { display: false },
                beforeDraw: function (chart) {
                    var width = chart.width,
                        height = chart.height,
                        ctx = chart.ctx;
                    ctx.restore();
                    var fontSize = (height / 114).toFixed(2);
                    ctx.font = fontSize + "em sans-serif";
                    ctx.textBaseline = "middle";

                    var text = chart.config.data.datasets[0].data[0] + "%",
                        textX = Math.round(
                            (width - ctx.measureText(text).width) / 2
                        ),
                        textY = height / 2;

                    ctx.fillText(text, textX, textY);
                    ctx.save();
                },
            },
            elements: {
                arc: {
                    borderWidth: 0,
                },
            },
        },
    };

    var availableJobsCtx = document
        .getElementById("availableJobsChart")
        .getContext("2d");
    setChartHeight("availableJobsChart", 250); // Set height to 250px, adjust as needed
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

    var openJobsCtx = document.getElementById("openJobsChart").getContext("2d");
    setChartHeight("openJobsChart", 250); // Set height to 250px, adjust as needed
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

    var closedJobsCtx = document
        .getElementById("closedJobsChart")
        .getContext("2d");
    setChartHeight("closedJobsChart", 250); // Set height to 250px, adjust as needed
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
