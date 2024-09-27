@extends('layouts.admin_pages')

@section('title', 'Employees')

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/shares.css') }}">
    <style>
          /* Container with background color */
        .employees-container {
            background-color: #D9D9D9;
            padding: 20px;
            border-radius: 8px;
            height: 183vh;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 15px;
            color: #0F5078;
            font-weight: bold;
        }
        .badge-full-time { background-color: #A6AAFF; color: #0F5078; }
        .badge-freelance { background-color: #A6AAFF; color: #0F5078; }

        .status-select {
            padding: 5px;
            font-weight: bold;
            color: #0F5078;
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

        .btn-sm{
            background-color: #0F5078;
            border: none;
            padding: 5px 10px;
            font-weight: bold;
            color: white;  
        }
    </style>
@endsection

@section('employees-content')

    <!-- Top Bar -->
    @include('components.topbar')
    <h2 class="mb-4 fw-bold text-primary" style="margin-top: -20px;"><i class="fa-solid fa-user-tie me-3"></i> All Employees</h2>
    <h6 class="mb-4 fw-bold text-primary" style="margin: -20px 0 0 54px;">All Employee Information</h6>
    <div class="employees-container mb-4">
        <!-- Search bar and Add New Candidate button -->
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="custom-search-bar">
                        <input type="text" placeholder="Search">
                        <button type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                <button class="btn btn-primary"><i class="fa-solid fa-circle-plus me-2"></i>Add New Employee</button>
            </div>
        </div>

        <!-- Applicant Result Table -->
        <div id="applicant-result-section" class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Employee Name</th>
                        <th>Employee ID</th>
                        <th>Project Department</th>
                        <th>Manager</th>
                        <th>Work Designation</th>
                        <th>Role</th>
                        <th>Work Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Carlo Dela Peña</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>Software Engineer</td>
                        <td>Office</td>
                        <td>
                            <select class="status-select badge-2nd-round">
                                <option value="Full-Time" class="badge-full-time">Full-Time</option>
                                <option value="Freelance" class="badge-freelance" selected>Freelance</option>
                            </select>
                        </td>
                        <td>
                            <button type="button" class="btn btn-outline-primary btn-sm">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <button type="button" class="btn btn-outline-primary btn-sm">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        // Ensure that the script only runs inside the specific 'result-content' area
        $(document).ready(function() {
            // Scope the script to the #applicant-result-section
            $('#applicant-result-section .status-select').each(function() {
                updateStatusColor(this);

                $(this).on('change', function () {
                    updateStatusColor(this);

                    // Send AJAX request to update status in the backend
                    const status = $(this).val();
                    const candidateId = $(this).data('id');

                    fetch(`/update-status/${candidateId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ status: status })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Status updated successfully');
                        } else {
                            alert('Failed to update status');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                });
            });

            // Function to change the background color of the select based on the selected option
            function updateStatusColor(selectElement) {
                const selectedOption = selectElement.options[selectElement.selectedIndex];
                const classList = selectedOption.className;
                selectElement.className = 'status-select ' + classList;
            }
        });
    </script>
@endsection
