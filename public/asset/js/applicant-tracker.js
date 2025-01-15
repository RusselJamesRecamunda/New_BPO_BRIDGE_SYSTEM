document.addEventListener("DOMContentLoaded", () => {
    // Extract the data from the data attributes of the div with id 'applicantChartData'
    var weeks = JSON.parse(
        document.getElementById("applicantChartData").dataset.weeks
    );
    var chartData = JSON.parse(
        document.getElementById("applicantChartData").dataset.chartData
    );

    // Create the chart
    var ctx = document.getElementById("applicantChart").getContext("2d");
    var applicantChart = new Chart(ctx, {
        type: "line",
        data: {
            labels: weeks, // Weekly labels
            datasets: [
                {
                    label: "Applications Data",
                    data: chartData, // Weekly data
                    backgroundColor: "rgba(54, 162, 235, 0.2)",
                    borderColor: "rgba(54, 162, 235, 1)",
                    borderWidth: 2,
                    fill: false,
                    tension: 0.1,
                },
            ],
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: "Applications Data by Week",
                },
            },
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    });

    // Update progress bars
    document.querySelectorAll(".progress-bar").forEach((bar) => {
        const percentage = bar.dataset.percentage;
        bar.style.width = `${percentage}%`;
    });
});
