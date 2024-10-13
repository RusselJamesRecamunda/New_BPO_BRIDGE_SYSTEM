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
            height: 183vh; /* Adjust to auto for dynamic content height */
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

        .btn-sm {
            background-color: #0F5078;
            border: none;
            padding: 5px 10px;
            font-weight: bold;
            color: white;  
        }
        .filter-card {
            width: 300px;
            position: absolute; /* Change from fixed to absolute */
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1050;
        }

        .blur-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            z-index: 1049;
        }
    </style>
@endsection

@section('employees-content')

    <!-- Top Bar -->
    @include('components.topbar')
    <h2 class="mb-4 fw-bold text-primary" style="margin-top: -20px;"><i class="fa-solid fa-user-tie me-3"></i> All Employees</h2>
    <h6 class="mb-4 fw-bold text-primary" style="margin: -20px 0 0 54px;">All Employee Information</h6>
    <div class="employees-container mb-4">
        <!-- Search bar, Add New Employee button, and Filter button -->
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="custom-search-bar">
                    <input type="text" placeholder="Search"> 
                    <button type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div>
                    <button class="btn btn-primary me-2" data-url="{{ route('add-employee.index') }}" id="addEmployeeButton">
                        <i class="fa-solid fa-circle-plus me-2"></i>Add New Employee
                    </button>
                    <button class="btn btn-secondary fw-bold" id="filterButton">
                        <i class="fa-solid fa-sliders me-2"></i>Filter
                    </button>
                </div>
            </div>

            <!-- Blur Overlay -->
            <div id="blurOverlay" class="blur-overlay" style="display: none;"></div>

            <!-- Filter Card -->
            <div id="filterCard" class="card p-3 shadow filter-card" style="display: none;">
                <h5 class="card-title">Filter</h5>
                <div class="mb-3">
                    <input type="text" class="form-control" placeholder="Search Employee" aria-label="Search Employee">
                </div>
                <div class="mb-3">
                    <h6>Department</h6>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="design">
                                <label class="form-check-label" for="design">Design</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="hr">
                                <label class="form-check-label" for="hr">HR</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="sales">
                                <label class="form-check-label" for="sales">Sales</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="java">
                                <label class="form-check-label" for="java">Java</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="python">
                                <label class="form-check-label" for="python">Python</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <h6>Select Type</h6>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="jobType" id="fullTime" value="Full-time">
                        <label class="form-check-label" for="fullTime">Full-time</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="jobType" id="freelance" value="Freelance">
                        <label class="form-check-label" for="freelance">Freelance</label>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button class="btn btn-light">Cancel</button>
                    <button class="btn btn-primary">Apply</button>
                </div>
            </div>
        </div>

        <!-- Employees Table -->
        <div id="employees-section" class="table-responsive">
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
        $(document).ready(function() {
    // Show filter card and overlay
    $('#filterButton').click(function() {
        $('#blurOverlay').toggle();
        $('#filterCard').toggle();
    });

    // Hide filter card and overlay when clicking outside of the filter card
    $(document).click(function(event) {
        if (!$(event.target).closest('#filterCard, #filterButton').length) {
            $('#filterCard').hide();
            $('#blurOverlay').hide();
        }
    });

    // Redirect when the add employee button is clicked
    document.getElementById('addEmployeeButton').addEventListener('click', function() {
        var url = this.getAttribute('data-url');
        window.location.href = url;
    });
});

    </script>
@endsection
