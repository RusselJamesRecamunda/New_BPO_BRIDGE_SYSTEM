@extends('layouts.admin_pages')

@section('title', 'Department Info')

@section('browser-icon')
    <link rel="icon" href="{{ asset('asset/img/browser-icons/bpo_icon.png') }}" type="image/x-icon">
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/shares.css') }}">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <style>
        /* Container with background color */
        .employees-container {
            background-color: #D9D9D9;
            padding: 20px;
            border-radius: 8px;
            height: 165vh;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 15px;
            color: #0F5078;
            font-weight: bold ;
        }
        .badge-full-time { 
            background-color: #A6AAFF; 
            color: #0F5078; 
        }
        .badge-freelance { 
            background-color: #A6AAFF; 
            color: #0F5078; 
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
            padding: 5px 10px;
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
        #admin-footer {
            margin-top: -10% !important;
        }
    </style>
@endsection

@section('department-info-content')
    <!-- Top Bar -->
    @include('components.topbar')
    <h2 class="mb-2 fw-bold text-dark">{{ $department }} Department</h2>
    <a href="{{ route('departments.index') }}" class="text-decoration-none">
        <h6 class="mb-4 fw-bold text-primary">
            <i class="fa-solid fa-circle-arrow-left"></i> All Departments
        </h6>
    </a>

    <div class="employees-container mb-4">
        <div class="table-responsive">
            <table id="departmentTable" class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Employee Name</th>
                        <th>Employee ID</th>
                        <th>Email</th>
                        <th>Work Designation</th>
                        <th>Work Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img 
                                        src="{{ asset('storage/' . $employee->emp_pic) }}" 
                                        alt="Avatar" 
                                        class="rounded-circle me-2" 
                                        style="width: 40px; height: 40px; object-fit: cover;">
                                    <span>{{ $employee->first_name }} {{ $employee->last_name }}</span>
                                </div>
                            </td>
                            <td>{{ $employee->official_emp_id }}</td>
                            <td>{{ $employee->email }}</td>
                            <td>{{ $employee->designation }}</td>
                            <td>
                                @if ($employee->work_status == 'Full-time')
                                    <span class="status-badge badge-full-time">Full-Time</span>
                                @elseif ($employee->work_status == 'Freelance')
                                    <span class="status-badge badge-freelance">Freelance</span>
                                @endif
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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    @section('scripts')
    <!-- DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
    $(document).ready(function() {
        // Initialize DataTable with custom page length options
        var table = $('#departmentTable').DataTable({
            "pageLength": 5,  // Set default number of entries to 5
            "lengthMenu": [5, 10, 15]  // Allow users to choose between 5, 10, and 15 entries
            });

            // Customize the search field with Bootstrap classes and custom styles
            var $searchInput = $('#departmentTable_filter input'); // Get the DataTable search input

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
                table.search("").draw(); // Clear the DataTable search and redraw the table
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
            $('#departmentTable_filter label')
                .contents()
                .filter(function () {
                    return this.nodeType === 3; // Node type 3 is text nodes
                })
                .remove();

            // Add the "Add New Employee" button to the right of the search field
            $('#departmentTable_filter').append(
                '<a class="btn btn-primary ms-3" href="{{ route("add-employee.index") }}" id="addEmployeeButton">' +
                    '<i class="fa-solid fa-circle-plus me-2"></i>Add New Employee' +
                '</a>'
            );
        });
    </script>
@endsection
