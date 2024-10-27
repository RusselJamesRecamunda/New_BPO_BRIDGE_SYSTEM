@extends('layouts.admin_pages')

@section('title', 'Manage Users')

@section('browser-icon')
    <link rel="icon" href="{{ asset('asset/img/browser-icons/manage.png') }}" type="image/x-icon">
@endsection


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
        .badge-active { background-color: #A6AAFF; color: #0F5078; }
        .badge-suspended { background-color: #A6AAFF; color: #0F5078; }

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

@section('users-content')

    <!-- Top Bar -->
    @include('components.topbar')
    <h2 class="mb-4 fw-bold text-primary" style="margin-top: -20px;"><i class="fa-solid fa-users-gear me-3"></i>User Management</h2>
    <div class="employees-container mb-4">
        <!-- Search bar and Add New Candidate button -->
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center">
            <h2 class="mb-4 fw-bold text-dark">Listed Users</h2>
                    <div class="custom-search-bar">
                        <input type="text" placeholder="Search">
                        <button type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
            </div>
        </div>

        <!-- User Management Table -->
        <div id="user-management-section" class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>User ID</th>
                        <th>User Name</th>
                        <th>User Role</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Date of birth</th>
                        <th>Activity Status</th>
                        <th>User Status</th>
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
                        <td></td>
                        <td>
                            <select class="status-select badge-status">
                                <option value="Active" class="badge-active">Active</option>
                                <option value="Suspended" class="badge-suspended" selected>Suspended</option>
                            </select>
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
            $('#user-management-section .status-select').each(function() {
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
