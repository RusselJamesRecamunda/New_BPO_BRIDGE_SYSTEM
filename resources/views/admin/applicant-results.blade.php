@extends('layouts.admin_pages')

@section('title', 'Applicant Result')

@section('browser-icon')
    <link rel="icon" href="{{ asset('asset/img/browser-icons/bpo_icon.png') }}" type="image/x-icon">
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/shares.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.7.0/css/select.dataTables.min.css">
    <style>
        /* Container with background color */
        .applicant-container {
            background-color: #D9D9D9;
            padding: 20px;
            border-radius: 8px;
            height: 193vh;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 15px;
            color: white;
            font-weight: bold;
        }
        .badge-1st-round { background-color: #4CAF50; color: white; }
        .badge-2nd-round { background-color: #FFC107; color: white; }
        .badge-on-hold { background-color: #FF9800; color: white; }
        .badge-hired { background-color: #2196F3; color: white; }
        .badge-rejected { background-color: #F44336; color: white; }

        .status-select {
            padding: 5px;
            font-weight: bold;
            color: white;
            border-radius: 5px;
            border: none;
        }

        .status-select option {
            font-weight: bold;
        }

        /* Table styles */
        table th, table td {
            text-align: center;
            vertical-align: middle;
        }

        /* Button styles */
        .btn-primary {
            background-color: #0F5078;
            border: none;
            padding: 10px 10px;
            font-weight: bold;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0C3E5A;
        }
    </style>
@endsection

@section('result-content')

    <!-- Top Bar -->
    @include('components.topbar')

    <div class="applicant-container mb-4">
        <!-- Search bar and Add New Candidate button -->
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="custom-search-bar">
                    <input type="text" placeholder="Search">
                    <button type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <button class="btn btn-primary"><i class="fa-solid fa-circle-plus me-2"></i>Add New Candidate</button>
            </div>
        </div>

        <!-- Applicant Result Table -->
        <div id="applicant-result-section" class="table-responsive">
            <table id="applicantTable" class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Candidate Name</th>
                        <th>Applying For</th>
                        <th>Resume/CV</th>
                        <th>Interview Date</th>
                        <th>Interview Score</th>
                        <th>Phone</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Carlo Dela Peña</td>
                        <td>Software Engineer</td>
                        <td><i class="bi bi-file-earmark"></i></td>
                        <td>2024-08-22</td>
                        <td>7</td>
                        <td>0921-123-4567</td>
                        <td>
                            <select class="status-select badge-2nd-round">
                                <option value="1st Round Passed" class="badge-1st-round">1st Round Passed</option>
                                <option value="2nd Round Passed" class="badge-2nd-round" selected>2nd Round Passed</option>
                                <option value="On-Hold" class="badge-on-hold">On-Hold</option>
                                <option value="Hired" class="badge-hired">Hired</option>
                                <option value="Rejected" class="badge-rejected">Rejected</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/select/1.7.0/js/dataTables.select.min.js"></script>
    <script>
        $(document).ready(function () {
            // Initialize DataTables with inline editing
            const table = $('#applicantTable').DataTable({
                select: true
            });

            // Make columns editable on click
            $('#applicantTable tbody').on('click', 'td', function () {
                const cell = table.cell(this);
                const columnIndex = cell.index().column;

                // Restrict editable columns
                const editableColumns = [0, 1, 3, 4, 5]; // Candidate Name, Applying For, Interview Date, Interview Score, Phone
                if (!editableColumns.includes(columnIndex)) return;

                const originalContent = cell.data();
                const input = $('<input>', {
                    type: 'text',
                    value: originalContent,
                    class: 'form-control',
                }).on('blur', function () {
                    const newValue = $(this).val();
                    cell.data(newValue).draw();

                    // Send updated data to the backend
                    const rowData = table.row(cell.index().row).data();
                    const candidateId = rowData[0]; // Assume Candidate Name is unique

                    $.ajax({
                        url: `/update-candidate/${candidateId}`,
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        },
                        data: {
                            column: columnIndex,
                            value: newValue,
                        },
                        success: function (response) {
                            if (response.success) {
                                alert('Data updated successfully');
                            } else {
                                alert('Failed to update data');
                                cell.data(originalContent).draw(); // Revert if failed
                            }
                        },
                        error: function () {
                            alert('An error occurred while updating the data.');
                            cell.data(originalContent).draw(); // Revert if error
                        },
                    });
                });

                $(this).html(input);
                input.focus();
            });
        });
    </script>
@endsection
