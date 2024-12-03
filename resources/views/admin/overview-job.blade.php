@extends('layouts.admin_pages')

@section('title', 'Overview Job Position')

@section('browser-icon')
    <link rel="icon" href="{{ asset('asset/img/browser-icons/bpo_icon.png') }}" type="image/x-icon">
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/shares.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/overview-job.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('overview-content')

    <!-- Top Bar -->
    @include('components.topbar')

    <!-- Search bar and Add New Candidate button -->
    <div class="job-container mb-4">
        <div class="d-flex justify-content-between mb-3">
            <!-- Tabs -->
            <div class="custom-tabs mb-3">
                <div class="custom-tab active" onclick="showTab('job-info')"> 
                    <i class="fa-solid fa-circle-info me-2"></i>Job Information
                </div>
                <div class="custom-tab" onclick="showTab('candidates')">
                    <i class="fa-solid fa-list me-2"></i>Candidates
                </div>
                <div class="custom-tab" onclick="showTab('documents')">
                    <i class="fas fa-file-alt me-2"></i>Documents
                </div>
            </div>

            <!-- Button -->
            <div class="ms-auto">
                <button class="btn btn-custom" type="button" data-url="{{ route('job-posting.index') }}" id="jobPostingButton">
                    <i class="fa-solid fa-circle-plus"></i> Post New Job
                </button>
            </div>
        </div>

        
        <!-- Job Info Content -->
        <div id="job-info" style="display: block;">
            <!-- Job Information -->
            <div class="row g-4">
                <!-- Left Section -->
                <div class="col-lg-8">
                    <div class="card p-4">
                        <a href="{{ route('jobs.index') }}" class="text-decoration-none mb-3 d-block"><i class="fa-solid fa-arrow-left"></i> Back to all jobs</a>
                        @if($job->job_title || $job->fl_job_title)
                            <h4>{{ $job->job_title ?? $job->fl_job_title }}</h4>
                        @endif
                        <p><i class="fa-solid fa-location-dot me-2"></i>{{ $job->job_location ?? $job->fl_job_location }}</p>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center">
                            <h5>Applied</h5>
                            <div>
                                <small>Applicants This Week</small>
                                <h3 class="text-primary">0</h3>
                            </div>
                        </div>
                        <!-- Chart -->
                        <canvas id="clickChart" class="click-chart my-3"></canvas>
                            <!-- Candidates Info -->
                        <div class="card mt-3">
                            <div class="card-body">
                                <h5 class="mb-4">Candidates</h5>
                                <div class="row">
                                    <!-- Awaiting Review Card -->
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h6 class="card-title text-center"><i class="fa-solid fa-clock-rotate-left me-3 text-warning"></i>Awaiting Review</h6>
                                                <p class="card-text text-center">Total: <span class="text-warning">0</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Accepted Card -->
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h6 class="card-title text-center"><i class="fa-regular fa-square-check me-3 text-success"></i>Accepted</h6>
                                                <p class="card-text text-center">Total: <span class="text-success">0</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Section -->
                <div class="col-lg-4">
                    <div class="card p-4">
                        <button class="btn btn-primary btn-block mb-3 fw-bold"><i class="fa-solid fa-pen-to-square me-3"></i>Edit Job</button>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Close Job</span>
                                <a href="#" class="text-decoration-none text-danger"><i class="fa-regular fa-circle-xmark"></i></a>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                                <span>Find Candidates for this Job</span>
                                <a href="#" class="text-decoration-none text-info"><i class="fa-solid fa-magnifying-glass"></i></a>
                            </li>
                        </ul>
                        <button class="btn btn-success btn-block mt-3 fw-bold"><i class="fa-solid fa-user-plus me-3"></i>Add Candidate</button>
                        <hr>
                        <p>Total Applied: <strong>0</strong></p>
                        <p>Candidates: <strong>0</strong></p>
                        <p>Job Status: <strong>{{ $job->job_status ?? $job->job_status }}</strong></p>
                        <p>Posted: <strong>{{ $job->creation_date->diffForHumans() }}</strong></p>
                        <button class="btn btn-outline-danger btn-block fw-bold"  type="button" data-url="{{ route('home') }}" id="viewHomeButton"><i class="fa-regular fa-eye me-3"></i>View Public Job Page</button>
                    </div>
                </div>
            </div>

            <!-- Job Details -->
            <div class="card mt-4">
                <div class="card-body">
                    <h5>{{ $job->category->category_name ?? 'Unknown Category' }}</h5>
                    <h6>{{ $job->jobType->job_type_name ?? 'Unknown Job Type' }}</h6>
                    <p><strong>Salary:</strong> <i class="fa-solid fa-peso-sign"></i> {{ $job->basic_pay ?? $job->fl_basic_pay }}</p>
                    <p><strong>Date Created:</strong> {{ $job->creation_date->format('F d, Y') }}</p>
		            @if($job->job_description || $job->fl_job_description)
                         <p>{!! $job->job_description ?? $job->fl_job_description !!}</p>
                    @endif
                    @if($job->requirements || $job->fl_requirements)
                        <p>{!! $job->requirements ?? $job->fl_requirements !!}</p>
        	        @endif
		            @if($job->company_benefits || $job->fl_company_benefits)
                       <p>{!! $job->company_benefits ?? $job->fl_company_benefits !!}</p>
            	    @endif
                </div>
            </div>
        </div>

        <!-- Candidates Content -->
        <div id="candidates" style="display: none;">
            <!-- Candidates Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Candidate Name</th>
                            <th>Applied Job</th>
                            <th>Date Applied</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Documents Content -->
        <div id="documents" style="display: none;">
            <!-- Documents Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Applicant Name</th>
                            <th>Applied For</th>
                            <th>Resume/Curriculum Vitae (CV)</th>
                            <th>Cover Letter</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Leslie Watson</td>
                            <td>UI/UX Designer</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Adding event listeners for both buttons
    document.querySelectorAll('#jobPostingButton, #viewHomeButton').forEach(button => {
        button.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            window.location.href = url;
        });
    });
</script>
    <script>
        function showTab(tabName) {
            // Hide all tabs
            document.getElementById('job-info').style.display = 'none';
            document.getElementById('candidates').style.display = 'none';
            document.getElementById('documents').style.display = 'none';

            // Show the selected tab
            document.getElementById(tabName).style.display = 'block';

            // Update active tab
            var tabs = document.querySelectorAll('.custom-tab');
            tabs.forEach(tab => {
                tab.classList.remove('active');
            });
            event.target.closest('.custom-tab').classList.add('active');
        }
    </script>
     <script>
        // Chart.js Integration
        const ctx = document.getElementById('clickChart').getContext('2d');
        const clickChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                datasets: [{
                    label: 'Applicants',
                    data: [0, 0, 0, 0, 0, 0, 0],
                    backgroundColor: 'rgba(124, 58, 237, 0.2)',
                    borderColor: '#7C3AED',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                }]
            },
            options: {
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    </script>
@endsection
