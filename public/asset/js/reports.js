async function exportStyledTableToExcel(
    tableId,
    filename = "New_Hire_Report.xlsx"
) {
    const { value: userDetails } = await Swal.fire({
        title: "To Confirm Your Report",
        html: `
            <div style="text-align: left;">
                <label for="nameInput" style="display: block; margin-bottom: 5px;">Please enter your name:</label>
                <input id="nameInput" class="swal2-input" placeholder="Your Name" style="width: 100%; height: 40px; margin-bottom: 20px; margin-left: 0;">
                <label for="signatureCanvas" style="display: block; margin-bottom: 5px;">Draw your signature below:</label>
                <canvas id="signatureCanvas" style="border: 1px solid #ccc; width: 100%; height: 150px;"></canvas>
            </div>
        `,
        didOpen: () => {
            const canvas = document.getElementById("signatureCanvas");
            const ctx = canvas.getContext("2d");
            let isDrawing = false;

            canvas.width = canvas.offsetWidth; // Set canvas width
            canvas.height = canvas.offsetHeight; // Set canvas height

            const startDrawing = (e) => {
                isDrawing = true;
                ctx.beginPath();
                const { x, y } = getCanvasPosition(e, canvas);
                ctx.moveTo(x, y);
            };

            const draw = (e) => {
                if (!isDrawing) return;
                const { x, y } = getCanvasPosition(e, canvas);
                ctx.lineTo(x, y);
                ctx.strokeStyle = "#000";
                ctx.lineWidth = 2;
                ctx.stroke();
            };

            const stopDrawing = () => {
                isDrawing = false;
                ctx.closePath();
            };

            const getCanvasPosition = (e, canvas) => {
                const rect = canvas.getBoundingClientRect();
                const x = (e.clientX || e.touches[0].clientX) - rect.left;
                const y = (e.clientY || e.touches[0].clientY) - rect.top;
                return { x, y };
            };

            // Event listeners for mouse and touch
            canvas.addEventListener("mousedown", startDrawing);
            canvas.addEventListener("mousemove", draw);
            canvas.addEventListener("mouseup", stopDrawing);
            canvas.addEventListener("mouseleave", stopDrawing);

            canvas.addEventListener("touchstart", startDrawing);
            canvas.addEventListener("touchmove", draw);
            canvas.addEventListener("touchend", stopDrawing);
        },
        showCancelButton: true,
        confirmButtonText: "Generate Report",
        preConfirm: () => {
            const name = document.getElementById("nameInput").value.trim();
            const canvas = document.getElementById("signatureCanvas");
            const signature = canvas.toDataURL();
            if (!name) {
                Swal.showValidationMessage("Name is required!");
                return false;
            }
            return { name, signature };
        },
    });

    if (!userDetails) return; // User canceled

    const { name, signature } = userDetails;
    const table = document.getElementById(tableId);
    const workbook = new ExcelJS.Workbook();
    const worksheet = workbook.addWorksheet("Report");

    // Add title row
    const title = "New Hire Report";
    worksheet.mergeCells("A1:H1");
    const titleCell = worksheet.getCell("A1");
    titleCell.value = title;
    titleCell.style = {
        font: {
            bold: true,
            color: { argb: "0F5078" },
            size: 20,
            name: "Arial",
        },
        alignment: { horizontal: "left", vertical: "middle" },
        fill: {
            type: "pattern",
            pattern: "solid",
            fgColor: { argb: "FFFFFF" },
        },
    };

    // Define headers
    const headers = [
        "EMPLOYEE NAME",
        "EMPLOYEE ID",
        "EMAIL ADDRESS",
        "TYPE OF WORK",
        "COMPANY DEPARTMENT",
        "DEPARTMENT MANAGER",
        "HIRE DATE",
    ];
    worksheet.addRow(headers);

    // Style headers
    headers.forEach((header, index) => {
        const cell = worksheet.getCell(2, index + 1);
        cell.value = header;
        cell.style = {
            font: {
                bold: true,
                color: { argb: "FFFFFF" },
                size: 13,
                name: "Arial",
            },
            alignment: { horizontal: "center", vertical: "middle" },
            fill: {
                type: "pattern",
                pattern: "solid",
                fgColor: { argb: "0F5078" },
            },
            border: {
                top: { style: "thin", color: { argb: "679FC1" } },
                bottom: { style: "thin", color: { argb: "679FC1" } },
                left: { style: "thin", color: { argb: "679FC1" } },
                right: { style: "thin", color: { argb: "679FC1" } },
            },
        };
    });

    // Add data rows
    const rows = Array.from(table.querySelectorAll("tbody tr")).filter(
        (row) => row.style.display !== "none"
    );
    rows.forEach((row, rowIndex) => {
        const rowData = Array.from(row.querySelectorAll("td")).map(
            (cell) => cell.innerText
        );
        const newRow = worksheet.addRow(rowData);

        const fillColor = rowIndex % 2 === 0 ? "96BAD1" : "C0DDEF";
        newRow.eachCell((cell, colIndex) => {
            cell.style = {
                fill: {
                    type: "pattern",
                    pattern: "solid",
                    fgColor: { argb: fillColor },
                },
                border: {
                    top: { style: "thin", color: { argb: "679FC1" } },
                    bottom: { style: "thin", color: { argb: "679FC1" } },
                    left: { style: "thin", color: { argb: "679FC1" } },
                    right: { style: "thin", color: { argb: "679FC1" } },
                },
            };
        });
    });

    // Add name, signature, and date
    const signatureRow = worksheet.getRow(7); // Row 7 for signature
    signatureRow.height = 50; // Adjust height for signature
    worksheet.mergeCells("A7:H7");
    const signatureImage = workbook.addImage({
        base64: signature,
        extension: "png",
    });
    worksheet.addImage(signatureImage, {
        tl: { col: 0, row: 6 }, // Top-left corner for signature image
        ext: { width: 150, height: 50 }, // Signature dimensions
    });

    const nameRow = worksheet.getRow(8); // Row 8 for name
    worksheet.mergeCells("A8:H8");
    nameRow.getCell(1).value = `Signed By: ${name}`;
    nameRow.getCell(1).style = {
        font: { italic: true, size: 12 },
        alignment: { horizontal: "left" },
    };

    const dateRow = worksheet.getRow(9); // Row 9 for date
    worksheet.mergeCells("A9:H9");
    dateRow.getCell(1).value = `Signed On: ${new Date().toLocaleDateString(
        "en-US",
        { year: "numeric", month: "long", day: "numeric" }
    )}`;
    dateRow.getCell(1).style = {
        font: { italic: true, size: 12 },
        alignment: { horizontal: "left" },
    };

    // Set column widths
    worksheet.columns = [
        { width: 50 },
        { width: 40 },
        { width: 65 },
        { width: 30 },
        { width: 40 },
        { width: 30 },
        { width: 50 },
        { width: 60 },
    ];

    // Export to Excel
    const buffer = await workbook.xlsx.writeBuffer();
    const blob = new Blob([buffer], {
        type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
    });
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = filename;
    link.click();
}

document.getElementById("weeklyBtn").addEventListener("click", function () {
    filterData("weekly");
});

document
    .getElementById("monthlyDropdown")
    .addEventListener("change", function () {
        filterData("monthly", this.value);
    });

function filterData(type, month = null) {
    const rows = document.querySelectorAll("#newHireTable tbody tr");
    const now = moment();

    rows.forEach((row) => {
        const createdAt = moment(
            row.querySelector("td:last-child").textContent,
            "MMMM D, YYYY"
        ); // Assuming created_at is the last column

        let showRow = false;

        if (type === "weekly") {
            // Check if created_at is within the last week
            showRow = createdAt.isSame(now, "week");
        } else if (type === "monthly" && month) {
            // Check if created_at is in the selected month
            showRow = createdAt.month() + 1 === parseInt(month);
        }

        // Toggle visibility based on filter
        row.style.display = showRow ? "" : "none";
    });
}

$(document).ready(function () {
    const newHireTable = $("#newHireTable").DataTable({
        lengthMenu: [5, 10, 15], // Set options for "Show entries"
        pageLength: 5, // Set the default number of entries
    });

    const submittedDocsTable = $("#submittedDocsTable").DataTable({
        lengthMenu: [5, 10, 15], // Set options for "Show entries"
        pageLength: 5, // Set the default number of entries
    });

    // Add custom search bar styles and behavior
    $(".dataTables_filter input")
        .addClass("form-control") // Apply Bootstrap form control class
        .attr("placeholder", "Search") // Add placeholder
        .css({
            display: "flex",
            width: "250px",
            "background-color": "#f2f2f2",
            "border-radius": "12px",
            "box-shadow": "0 1px 5px rgba(0, 0, 0, 0.1)",
            color: "#0c436d",
            "font-weight": "600",
            "padding-right": "35px", // Space for cancel button
            position: "relative",
        })
        .wrap(
            '<div class="search-container position-relative mt-2 mb-2"></div>'
        );

    // Add magnifying glass and clear icons
    $(".dataTables_filter input")
        .parent()
        .append(
            '<i class="fa-solid fa-magnifying-glass position-absolute search-icon" style="right: 10px; top: 50%; transform: translateY(-50%); color: #0c436d;"></i>' +
                '<i class="fa-solid fa-xmark position-absolute clear-search" style="right: 10px; top: 50%; transform: translateY(-50%); color: #0c436d; opacity: 0; cursor: pointer;"></i>'
        );

    const $searchInput = $(".dataTables_filter input");
    const $searchContainer = $searchInput.parent();

    $searchInput.on("input", function () {
        const $magnifyingGlass = $searchContainer.find(".search-icon");
        const $clearButton = $searchContainer.find(".clear-search");

        if ($(this).val().length > 0) {
            $magnifyingGlass.css("opacity", "0");
            $clearButton.css("opacity", "1");
        } else {
            $magnifyingGlass.css("opacity", "1");
            $clearButton.css("opacity", "0");
        }
    });

    $searchContainer.find(".clear-search").on("click", function () {
        $searchInput.val("").trigger("input"); // Clear input and reset icons
        newHireTable.search("").draw(); // Reset table search
    });

    // Hide native cancel button
    const style = document.createElement("style");
    style.textContent = `
        .dataTables_filter input::-webkit-search-cancel-button {
            display: none;
        }
    `;
    document.head.appendChild(style);

    // Remove "Search:" label
    $(".dataTables_filter label")
        .contents()
        .filter(function () {
            return this.nodeType === 3; // Text nodes
        })
        .remove();
});

function showTab(tabName) {
    document.getElementById("new-hire-info").style.display = "none";
    document.getElementById("submitted-documents").style.display = "none";
    document.getElementById(tabName).style.display = "block";

    const tabs = document.querySelectorAll(".custom-tab");
    tabs.forEach((tab) => tab.classList.remove("active"));
    event.target.closest(".custom-tab").classList.add("active");
}
