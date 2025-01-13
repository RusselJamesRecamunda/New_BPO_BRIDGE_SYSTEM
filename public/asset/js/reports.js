async function exportStyledTableToExcel(tableId, filename = 'Styled_Report.xlsx') {
    const table = document.getElementById(tableId); // Get the table element
    const workbook = new ExcelJS.Workbook(); // Create a new workbook
    const worksheet = workbook.addWorksheet('Report'); // Add a new worksheet

    // Add title row
    const title = 'New Hire Report'; // Fixed title
    worksheet.mergeCells('A1:H1'); // Merge cells for title
    const titleCell = worksheet.getCell('A1');
    titleCell.value = title;
    titleCell.style = {
        font: { bold: true, color: { argb: '0F5078' }, size: 20, name: 'Arial' },
        alignment: { horizontal: 'left', vertical: 'middle' }, // Align title to the left
        fill: { type: 'pattern', pattern: 'solid', fgColor: { argb: 'FFFFFF' } },
    };

    // Define headers
    const headers = [
        'EMPLOYEE NAME', 'EMPLOYEE ID', 'EMAIL ADDRESS', 'TYPE OF WORK',
        'COMPANY DEPARTMENT', 'DEPARTMENT MANAGER', 'HIRE DATE',
    ];
    worksheet.addRow(headers); // Add header row

    // Style headers (starting from column A)
    headers.forEach((header, index) => {
        const cell = worksheet.getCell(2, index + 1); // Row 2, starting from column A
        cell.value = header; // Set header value
        cell.style = {
            font: { bold: true, color: { argb: 'FFFFFF' }, size: 13, name: 'Arial' },
            alignment: { horizontal: 'center', vertical: 'middle' },
            fill: { type: 'pattern', pattern: 'solid', fgColor: { argb: '0F5078' } },
            border: {
                top: { style: 'thin', color: { argb: '679FC1' } },
                bottom: { style: 'thin', color: { argb: '679FC1' } },
                left: { style: 'thin', color: { argb: '679FC1' } },
                right: { style: 'thin', color: { argb: '679FC1' } },
            },
        };
    });

    // Add data rows (only visible rows)
    const rows = Array.from(table.querySelectorAll('tbody tr')).filter(row => row.style.display !== 'none'); // Only visible rows
    rows.forEach((row, rowIndex) => {
        const rowData = Array.from(row.querySelectorAll('td')).map((cell) => cell.innerText);
        const newRow = worksheet.addRow(rowData);

        // Apply alternating row styles
        const fillColor = rowIndex % 2 === 0 ? '96BAD1' : 'C0DDEF'; // Alternating colors
        newRow.eachCell((cell, colIndex) => {
            cell.style = {
                fill: { type: 'pattern', pattern: 'solid', fgColor: { argb: fillColor } },
                border: {
                    top: { style: 'thin', color: { argb: '679FC1' } },
                    bottom: { style: 'thin', color: { argb: '679FC1' } },
                    left: { style: 'thin', color: { argb: '679FC1' } },
                    right: { style: 'thin', color: { argb: '679FC1' } },
                },
            };
        });
    });

    // Set column widths
    worksheet.columns = [
        { width: 50 }, // Column A (empty)
        { width: 40 }, // Column B (EMPLOYEE NAME)
        { width: 65 }, // Column C
        { width: 30 }, // Column D
        { width: 40 }, // Column E
        { width: 30 }, // Column F
        { width: 50 }, // Column G
        { width: 60 }, // Column H
    ];

    // Export to Excel
    const buffer = await workbook.xlsx.writeBuffer();
    const blob = new Blob([buffer], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
    const link = document.createElement('a');
    link.href = URL.createObjectURL(blob);
    link.download = filename;
    link.click();
}

document.getElementById('weeklyBtn').addEventListener('click', function() {
    filterData('weekly');
});

document.getElementById('monthlyDropdown').addEventListener('change', function() {
    filterData('monthly', this.value);
});

function filterData(type, month = null) {
    const rows = document.querySelectorAll('#newHireTable tbody tr');
    const now = moment();
    
    rows.forEach(row => {
        const createdAt = moment(row.querySelector('td:last-child').textContent, 'MMMM D, YYYY'); // Assuming created_at is the last column
        
        let showRow = false;
        
        if (type === 'weekly') {
            // Check if created_at is within the last week
            showRow = createdAt.isSame(now, 'week');
        } else if (type === 'monthly' && month) {
            // Check if created_at is in the selected month
            showRow = createdAt.month() + 1 === parseInt(month);
        }

        // Toggle visibility based on filter
        row.style.display = showRow ? '' : 'none';
    });
}

$(document).ready(function() {
    const newHireTable = $('#newHireTable').DataTable({
        lengthMenu: [5, 10, 15], // Set options for "Show entries"
        pageLength: 5, // Set the default number of entries
    });

    const submittedDocsTable = $('#submittedDocsTable').DataTable({
        lengthMenu: [5, 10, 15], // Set options for "Show entries"
        pageLength: 5, // Set the default number of entries
    });

    // Add custom search bar styles and behavior
    $('.dataTables_filter input')
        .addClass('form-control') // Apply Bootstrap form control class
        .attr('placeholder', 'Search') // Add placeholder
        .css({
            display: 'flex',
            width: '250px',
            'background-color': '#f2f2f2',
            'border-radius': '12px',
            'box-shadow': '0 1px 5px rgba(0, 0, 0, 0.1)',
            color: '#0c436d',
            'font-weight': '600',
            'padding-right': '35px', // Space for cancel button
            position: 'relative',
        })
        .wrap('<div class="search-container position-relative mt-2 mb-2"></div>');

    // Add magnifying glass and clear icons
    $('.dataTables_filter input')
        .parent()
        .append(
            '<i class="fa-solid fa-magnifying-glass position-absolute search-icon" style="right: 10px; top: 50%; transform: translateY(-50%); color: #0c436d;"></i>' +
            '<i class="fa-solid fa-xmark position-absolute clear-search" style="right: 10px; top: 50%; transform: translateY(-50%); color: #0c436d; opacity: 0; cursor: pointer;"></i>'
        );

    const $searchInput = $('.dataTables_filter input');
    const $searchContainer = $searchInput.parent();

    $searchInput.on('input', function() {
        const $magnifyingGlass = $searchContainer.find('.search-icon');
        const $clearButton = $searchContainer.find('.clear-search');

        if ($(this).val().length > 0) {
            $magnifyingGlass.css('opacity', '0');
            $clearButton.css('opacity', '1');
        } else {
            $magnifyingGlass.css('opacity', '1');
            $clearButton.css('opacity', '0');
        }
    });

    $searchContainer.find('.clear-search').on('click', function() {
        $searchInput.val('').trigger('input'); // Clear input and reset icons
        newHireTable.search('').draw(); // Reset table search
    });

    // Hide native cancel button
    const style = document.createElement('style');
    style.textContent = `
        .dataTables_filter input::-webkit-search-cancel-button {
            display: none;
        }
    `;
    document.head.appendChild(style);

    // Remove "Search:" label
    $('.dataTables_filter label').contents().filter(function() {
        return this.nodeType === 3; // Text nodes
    }).remove();
});

function showTab(tabName) {
    document.getElementById('new-hire-info').style.display = 'none';
    document.getElementById('submitted-documents').style.display = 'none';
    document.getElementById(tabName).style.display = 'block';

    const tabs = document.querySelectorAll('.custom-tab');
    tabs.forEach(tab => tab.classList.remove('active'));
    event.target.closest('.custom-tab').classList.add('active');
}
