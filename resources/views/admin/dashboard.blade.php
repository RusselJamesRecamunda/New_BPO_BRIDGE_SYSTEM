@extends('layouts.admin_dashboard')

@section('title', 'Dashboard')

@section('browser-icon')
    <link rel="icon" href="{{ asset('asset/img/browser-icons/dashboard.png') }}" type="image/x-icon">
@endsection

@section('styles')
    <!-- Add additional styles specific to this view here -->
    <link rel="stylesheet" href="{{ asset('asset/css/shares.css') }}">
@endsection

@section('content')
        <!-- Top Bar -->
        @include('components.topbar')

        <!-- Dashboard Header and Stats Cards -->
        <div class="mb-4">
            <h2 class="mb-4 fw-bold text-primary" style="margin-top: -10px;"><i class="fas fa-home fa-1x me-3"></i> Dashboard</h2>
            <div class="row">
                <!-- First Card -->
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card bg-custom-1 text-white p-3 text-center">
                        <p class="mb-3 fw-bold">Scheduled Interviews</p>
                        <div class="d-flex justify-content-center align-items-center">
                            <i class="fa-solid fa-calendar-day fa-3x me-4"></i>
                            <h2 class="mb-0">100</h2>
                        </div>
                    </div>
                </div>

                <!-- Other Cards -->
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card bg-custom-2 text-white p-3 text-center">
                        <p class="mb-3 fw-bold">Total Employees</p>
                        <div class="d-flex justify-content-center align-items-center">
                            <i class="fa fa-users fa-3x me-4"></i>
                            <h2 class="mb-0">470</h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card bg-custom-3 text-white p-3 text-center">
                        <p class="mb-3 fw-bold">Applications Sent</p>
                        <div class="d-flex justify-content-center align-items-center">
                            <i class="fa-solid fa-check-to-slot fa-3x me-4"></i>
                            <h2 class="mb-0">753</h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card bg-custom-4 text-white p-3 text-center">
                        <p class="mb-3 fw-bold">Total Users</p>
                        <div class="d-flex justify-content-center align-items-center">
                            <i class="fas fa-user fa-3x me-4"></i>
                            <h2 class="mb-0">970</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
          
        <!-- Additional Content -->
        <div class="row">
            <!-- Donut Charts Section -->
            <div class="col-lg-3 col-md-4">
                <!-- Recent Activities Section -->
                <div class="card dashboard-donut-card p-4 mb-4 extended-card">
                    <!-- Donut Charts -->
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-center donut-chart-container">
                            <canvas id="availableJobsChart" width="80" height="80"></canvas>
                            <p class="mb-0 custom-chart">Available Jobs</p>
                        </div>
                        <div class="text-center donut-chart-container">
                            <canvas id="openJobsChart" width="80" height="80"></canvas>
                            <p class="mb-0 custom-chart">Open Jobs</p>
                        </div>
                        <div class="text-center donut-chart-container">
                            <canvas id="closedJobsChart" width="80" height="80"></canvas>
                            <p class="mb-0 custom-chart">Closed Jobs</p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Recent Activities</h5>
                    </div>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="mb-1">Your application has been accepted in 5 Vacancies</p>
                                    <small class="text-muted">12h ago</small>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="mb-1">Your application has been accepted in 4 Vacancies</p>
                                    <small class="text-muted">12h ago</small>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="mb-1">Your application has been accepted in 3 Vacancies</p>
                                    <small class="text-muted">12h ago</small>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="mb-1">Your application has been accepted in 2 Vacancies</p>
                                    <small class="text-muted">14h ago</small>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item px-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="mb-1">Your application has been accepted in 1 Vacancy</p>
                                    <small class="text-muted">16h ago</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-3">
                        <button class="btn btn-light text-primary border border-primary btn-sm">
                            See Activities <i class="fas fa-external-link-alt"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Vacancy Stats Section -->
            <div class="col-lg-9 col-md-8">
                <div class="card p-4 mb-4 d-flex flex-column" style="height: 130vh;">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0 fw-bold">Vacancy Status</h5>
                        <button class="btn btn-primary fw-bold" type="button" data-bs-toggle="modal" data-bs-target="#datePickerModal">
                            <i class="fa-solid fa-calendar-days me-2"></i>This Month
                        </button>
                    </div>
                    <canvas id="vacancyStatsChart"></canvas>
                </div>
            </div>

            <!-- Modal for Date Picker -->
            <div class="modal fade" id="datePickerModal" tabindex="-1" aria-labelledby="datePickerModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="datePickerModalLabel">Select Month and Year</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="month" id="monthYearPicker" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('scripts')
    <!-- Add additional scripts specific to this view here -->
    <script src="{{ asset('asset/js/dashboard.js') }}"></script>
    <script src="{{ asset('asset/js/sidebar.js') }}"></script>
@endsection
