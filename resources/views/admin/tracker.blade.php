@extends('layouts.admin_pages')

@section('title', 'Applicant Tracker')

@section('styles')
    <!-- Add additional styles specific to this view here -->
    <link rel="stylesheet" href="{{ asset('asset/css/shares.css') }}">
@endsection

@section('tracker-content')
            <!-- Top Bar -->
            @include('components.topbar')

            <!-- Tracker Cards -->
            <div class="mb-4">
                <h2 class="mb-4 fw-bold text-primary" style="margin-top: -10px;"><i class="fa-solid fa-chart-bar fa-1x me-3"></i>Applicant Tracker</h2>
                <div class="row">
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="card text-center" style="background-color: #97BAEF; color:#FFFF; height: 20vh; width: 85%">
                            <div class="card-body">
                                <h6 class="card-title">New Candidates</h6>
                                <h2 class="card-text">35</h2>
                                <p class="text-muted">Last 7 Days</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="card text-center" style="background-color: #97BAEF; color:#FFFF; height: 20vh; width: 85%">
                            <div class="card-body">
                                <h6 class="card-title">Job Applications</h6>
                                <h2 class="card-text">59</h2>
                                <p class="text-muted">Last 7 Days</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="card text-center" style="background-color: #97BAEF; color:#FFFF; height: 20vh; width: 85%">
                            <div class="card-body">
                                <h6 class="card-title">Total Candidates</h6>
                                <h2 class="card-text">587</h2>
                                <p class="text-muted">Last 7 Days</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 mb-3">
                        <div class="card text-center" style="background-color: #97BAEF; color:#FFFF; height: 20vh; width: 85%">
                            <div class="card-body">
                                <h6 class="card-title">New Hires</h6>
                                <h2 class="card-text">25</h2>
                                <p class="text-muted">Last 7 Days</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Additional Content -->
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    
                </div>

                <!-- Vacancy Stats Section -->
            <!-- Charts and Other Data -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <!-- Insert Chart Here -->
                            <canvas id="applicantChart" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Upcoming Interviews</h5>
                            <ul class="list-group">
                                <li class="list-group-item">John Doe <span class="text-muted">09:20 - 09:45</span></li>
                                <li class="list-group-item">Jane Smith <span class="text-muted">10:20 - 10:45</span></li>
                                <!-- Add more items -->
                            </ul>
                            <div class="text-center mt-3">
                                <a href="#" class="btn btn-primary">See Schedules</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Applicants to Review -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Applicants to Review</h5>
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th>Position</th>
                                <th>Published</th>
                                <th>Number of Candidates</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Senior Python Developer</td>
                                <td>May 15, 2024</td>
                                <td><div class="progress"><div class="progress-bar bg-primary" style="width: 80%;"></div></div></td>
                            </tr>
                            <tr>
                                <td>Full Stack Developer</td>
                                <td>Jun 18, 2024</td>
                                <td><div class="progress"><div class="progress-bar bg-info" style="width: 50%;"></div></div></td>
                            </tr>
                            <!-- Add more rows -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <!-- Add chart.js script for the chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('applicantChart').getContext('2d');
        var applicantChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['New Candidates', 'Job Applications', 'Total Candidates', 'Total Hires'],
                datasets: [{
                    label: 'Applicants Data',
                    data: [35, 59, 587, 25],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

@endsection
