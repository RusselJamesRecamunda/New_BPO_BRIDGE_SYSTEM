@extends('layouts.admin_pages')

@section('title', 'Employees')

@section('browser-icon')
    <link rel="icon" href="{{ asset('asset/img/browser-icons/bpo_icon.png') }}" type="image/x-icon">
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/shares.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/employee.css') }}">
@endsection

@section('employees-content')
    <!-- Top Bar -->
    @include('components.topbar')
    <h2 class="mb-4 fw-bold text-primary" style="margin-top: -20px;"><i class="fa-solid fa-user-tie me-3"></i> All Employees</h2>
    <h6 class="mb-4 fw-bold text-primary" style="margin: -20px 0 0 54px;">All Employee Information</h6>
    <div class="employees-container mb-4">
        <div class="row mb-4">
            <!-- Total Employee Card -->
            <div class="col-md-3">
                <div class="card p-3 shadow-sm">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h6 class="mb-0">Employees</h6>
                            <h3 class="mb-0">614</h3>
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
                            <h3 class="mb-0">124</h3>
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
                            <h3 class="mb-0">504</h3>
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
                            <h3 class="mb-0">110</h3>
                        </div>
                        <canvas id="femaleEmployeeChart" width="100" height="40"></canvas>
                    </div>
                </div>
            </div>
        </div>
    
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
                    <!-- Blur Overlay -->
                    <div id="blurOverlay" class="blur-overlay" style="display: none;"></div>

                    <!-- Filter Card -->
                    <div id="filterCard" class="card p-3 shadow filter-card" style="display: none;">
                        <h5 class="card-title">Filter</h5>
                    </div>
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
                        <th>Phone</th>
                        <th>Project Department</th>
                        <th>Date Hired</th>
                        <th>Work Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
<!-- Include Chart.js library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  // Generate ordered data for compact charts
function generateCompactData() {
    // Array of ascending values from small to high
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
                duration: 1000 // Animation duration only on load
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
