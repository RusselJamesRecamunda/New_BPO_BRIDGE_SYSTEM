@extends('layouts.admin_pages')

@section('title', 'Applicant Result')

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/shares.css') }}">
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
            <table class="table table-bordered table-hover align-middle">
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
                    <!-- More rows -->
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
