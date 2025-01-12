@extends('layouts.admin_pages')

@section('title', 'Employees')

@section('browser-icon')
    <link rel="icon" href="{{ asset('asset/img/browser-icons/bpo_icon.png') }}" type="image/x-icon">
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/shares.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/employee.css') }}">

    <!-- Include DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endsection

@section('employees-content')
    <!-- Top Bar -->
    @include('components.topbar')
    <h2 class="mt-4 mb-4 fw-bold text-primary"><i class="fa-solid fa-user-tie me-3"></i> All Employees</h2>
    <h6 class="mb-4 fw-bold text-primary" style="margin: -20px 0 0 54px;">All Employee Information</h6>
    <div class="employees-container mb-4">
    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: "{{ session('success') }}",
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: "{{ session('error') }}",
                    confirmButtonText: 'OK'
                });
            });
        </script>
    @endif
        <div class="row mb-4">
            <!-- Total Employee Card -->
            <div class="col-md-3">
                <div class="card p-3 shadow-sm">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-0">Employees</h6>
                            <h3 class="mb-0">{{ $employeeCount }}</h3>
                        </div>
                        <canvas id="totalEmployeeChart" width="100" height="40"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- New Employee Card -->
            <div class="col-md-3">
                <div class="card p-3 shadow-sm">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-0">New Hires</h6>
                            <h3 class="mb-0">{{$newHiresCount}}</h3>
                        </div>
                        <canvas id="newEmployeeChart" width="100" height="40"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Male Employee Card -->
            <div class="col-md-3">
                <div class="card p-3 shadow-sm">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-0">Freelance</h6>
                            <h3 class="mb-0">{{$freelanceCount}}</h3>
                        </div>
                        <canvas id="maleEmployeeChart" width="100" height="40"></canvas>
                    </div>
                </div>
            </div>
            
            <!-- Female Employee Card -->
            <div class="col-md-3">
                <div class="card p-3 shadow-sm">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-0">Full-Time</h6>
                            <h3 class="mb-0">{{$fullTimeCount}}</h3>
                        </div>
                        <canvas id="femaleEmployeeChart" width="100" height="40"></canvas>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Search bar, Add New Employee button, and Filter button -->
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="ms-auto">
                    <button class="btn btn-primary" data-url="{{ route('add-employee.index') }}" id="addEmployeeButton">
                        <i class="fa-solid fa-circle-plus me-2"></i>Add New Employee
                    </button>
                </div>
            </div>
        </div>

        
        <!-- Employees Table -->
        <div id="employees-section" class="table-responsive">
            <table id="employeesTable" class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Employee Name</th>
                        <th>Employee ID</th>
                        <th>Phone</th>
                        <th>Project Department</th>
                        <th>Date Hired</th>
                        <th>Work Status</th>
                        <th>Manage Employee</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                        <tr>
                            <!-- Employee Name with Profile Picture -->
                            <td>
                                @if($employee->emp_pic)
                                    <img src="{{ asset('storage/' . $employee->emp_pic) }}" alt="Profile Picture" class="img-fluid rounded-circle" style="width: 40px; height: 40px; margin-right: 10px;">
                                @else
                                    <img src="{{ asset('storage/default-avatar.png') }}" alt="Default Profile" class="img-fluid rounded-circle" style="width: 40px; height: 40px; margin-right: 10px;">
                                @endif
                                {{ $employee->first_name }} {{ $employee->last_name }}
                            </td>

                            
                            <!-- Employee ID -->
                            <td>{{ $employee->official_emp_id }}</td>
                            
                            <!-- Phone -->
                            <td>{{ $employee->phone }}</td>
                            
                            <!-- Project Department -->
                            <td>{{ $employee->project_department }}</td>
                            
                            <!-- Date Hired -->
                            <td>{{ \Carbon\Carbon::parse($employee->hire_date)->format('F d, Y') }}</td>
                            
                            <!-- Work Status with badge -->
                            <td>
                                <span class="status-badge 
                                    @if($employee->work_status == 'Full-time') badge-full-time 
                                    @elseif($employee->work_status == 'Freelance') badge-freelance 
                                    @else '' 
                                    @endif">
                                    {{ $employee->work_status ?? 'N/A' }}
                                </span>
                            </td>
                            
                            <!-- Action Buttons -->
                            <td>
                                <button type="button" class="btn btn-outline-primary btn-sm" title="View">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm" title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('scripts')
<!-- Include Chart.js library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Include DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script>
    // Initialize DataTable
    $(document).ready(function() {
        $('#employeesTable').DataTable({
            "responsive": true,
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "lengthChange": true, // Enable the ability to change the number of rows displayed
            "lengthMenu": [5, 10, 15], // Options for the number of rows to display
        });

        // Redirect when the add employee button is clicked
        document.getElementById('addEmployeeButton').addEventListener('click', function() {
            var url = this.getAttribute('data-url');
            window.location.href = url;
        });

        // Customize the search bar
        const $searchInput = $('#employeesTable_filter input');

        // Add styles and wrap the search input
        $searchInput
            .addClass("form-control") // Apply Bootstrap form control class
            .attr("placeholder", "Search") // Add a placeholder to the input
            .css({
                display: "flex",
                width: "250px",
                "background-color": "#f2f2f2",
                "border-radius": "12px",
                "box-shadow": "0 1px 5px rgba(0, 0, 0, 0.1)",
                color: "#0c436d",
                "font-weight": "600",
                "padding-right": "35px", // Space for the cancel button
                position: "relative",
            });

        // Wrap input field in a container for better positioning of the icons
        $searchInput.wrap('<div class="search-container position-relative mt-2 mb-2"></div>');

        // Add the magnifying glass icon to the right
        $searchInput
            .parent()
            .append(
                '<i class="fa-solid fa-magnifying-glass position-absolute search-icon" style="right: 10px; top: 50%; transform: translateY(-50%); color: #0c436d;"></i>'
            );

        // Add the custom cancel button
        $searchInput
            .parent()
            .append(
                '<i class="fa-solid fa-xmark position-absolute clear-search" style="right: 10px; top: 50%; transform: translateY(-50%); color: #0c436d; opacity: 0; cursor: pointer;"></i>'
            );

        const $searchContainer = $searchInput.parent();

        // Add an event listener to toggle magnifying glass visibility based on input
        $searchInput.on("input", function () {
            const $magnifyingGlass = $searchContainer.find(".search-icon");
            const $clearButton = $searchContainer.find(".clear-search");

            if ($(this).val().length > 0) {
                // Hide magnifying glass and show cancel button
                $magnifyingGlass.css("opacity", "0");
                $clearButton.css("opacity", "1");
            } else {
                // Show magnifying glass and hide cancel button
                $magnifyingGlass.css("opacity", "1");
                $clearButton.css("opacity", "0");
            }
        });

        // Clear the search input when the cancel button is clicked
        $searchContainer.find(".clear-search").on("click", function () {
            $searchInput.val("").trigger("input"); // Clear the input and trigger the event to reset icons
            $('#employeesTable').DataTable().search("").draw(); // Clear the DataTable search and redraw the table
        });

        // Hide the native cancel button provided by DataTables
        const style = document.createElement("style");
        style.textContent = `
            .dataTables_filter input::-webkit-search-cancel-button {
                display: none; /* Hide the native cancel button */
            }
        `;
        document.head.appendChild(style);

        // Remove the "Search:" label
        $('#employeesTable_filter label')
            .contents()
            .filter(function () {
                return this.nodeType === 3; // Node type 3 is text nodes
            })
            .remove();
    });

    // Generate ordered data for compact charts
    function generateCompactData() {
        return [10, 20, 30, 40, 50];
    }

    // Initialize a compact chart
    function initializeCompactChart(ctx, color) {
        return new Chart(ctx, {
            type: 'bar',
            data: {
                labels: Array.from({ length: 4 }, (_, i) => i + 1),
                datasets: [{
                    label: 'Data',
                    backgroundColor: color,
                    borderColor: color,
                    data: generateCompactData(),
                }]
            },
            options: {
                responsive: false,
                maintainAspectRatio: false,
                animation: {
                    duration: 1000
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        display: false
                    },
                    x: {
                        display: false
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                },
                layout: {
                    padding: 0
                }
            }
        });
    }

    // Initialize charts for each card only once on page load
    const totalEmployeeChart = initializeCompactChart(document.getElementById('totalEmployeeChart'), 'rgba(54, 162, 235, 1)');
    const newEmployeeChart = initializeCompactChart(document.getElementById('newEmployeeChart'), 'rgba(75, 192, 192, 1)');
    const maleEmployeeChart = initializeCompactChart(document.getElementById('maleEmployeeChart'), 'rgba(153, 102, 255, 1)');
    const femaleEmployeeChart = initializeCompactChart(document.getElementById('femaleEmployeeChart'), 'rgba(255, 159, 64, 1)');
</script>

@endsection
