@extends('layouts.admin_pages')

@section('title', 'Overview Job Position')

@section('browser-icon')
    <link rel="icon" href="{{ asset('asset/img/browser-icons/bpo_icon.png') }}" type="image/x-icon">
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/shares.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/overview-job.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                            <h5>Applied For This Job</h5>
                            <div>
                                <small>Applicants This Week</small>
                                <h3 class="text-primary">{{ $totalApplicantsThisWeek }}</h3>
                            </div>
                        </div>
                        <!-- Chart -->
                        <canvas id="clickChart" class="click-chart my-3"></canvas>
                            <!-- Candidates Info -->
                        <div class="card mt-3">
                            <div class="card-body">
                                <h5 class="mb-4">Candidates</h5>
                                <div class="row">
                                    <!-- Pending Review Card -->
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h6 class="card-title text-center"><i class="fa-solid fa-clock-rotate-left me-3 text-warning"></i>Pending Review</h6>
                                                <p class="card-text text-center">Total: <span class="text-warning">{{ $pendingCount }}</span></p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Qualified Card -->
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <h6 class="card-title text-center"><i class="fa-regular fa-square-check me-3 text-success"></i>Qualified for Interview</h6>
                                                <p class="card-text text-center">Total: <span class="text-success">{{ $qualifiedCount }}</span></p>
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
                    <a href="{{ route('job-posting.edit', ['id' => $job->full_job_ID ?? $job->fl_jobID]) }}" class="btn btn-primary btn-block mb-3 fw-bold">
                        <i class="fa-solid fa-pen-to-square me-3"></i>Edit Job
                    </a>

                        <ul class="list-group list-group-flush">
                            <button class="btn btn-danger btn-block mt-3 fw-bold"><i class="fa-solid fa-lock me-3"></i>Close Job</button>
                        </ul>
                        <hr>
                        <button class="btn btn-warning btn-block fw-bold text-light mb-4"  type="button" data-url="{{ route('home') }}" id="viewHomeButton"><i class="fa-regular fa-eye me-3"></i>View Public Job Page</button>
                        <p>Total Applied: <strong>{{ $appliedCount }}</strong></p>
                        <p>Job Status: <strong>{{ $job->job_status ?? $job->job_status }}</strong></p>
                        <p>Posted: <strong>{{ $job->creation_date->diffForHumans() }}</strong></p>
                    </div>
                </div>
            </div>

            <!-- Job Details -->
            <div class="card mt-4">
                <div class="card-body">
                    <h5>{{ $job->category->category_name ?? 'Unknown Category' }}</h5>
                    <h6>{{ $job->jobType->job_type_name ?? 'Unknown Job Type' }}</h6>
                    <p><strong>Starting Salary:</strong> <i class="fa-solid fa-peso-sign"></i> {{ $job->basic_pay ?? $job->fl_basic_pay }}</p>
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
                            <th>Application Status</th>
                            <th>Applied Job</th>
                            <th>Date Applied</th>
                            <th>Candidate Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($detailedApplications as $application)
                        <tr>
                            <td>{{ $application->applicant_name }}</td>
                            <td>{{ $application->application_status }}</td>
                            <td>
                                @if($job->job_title || $job->fl_job_title)
                                    {{ $job->job_title ?? $job->fl_job_title }}
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($application->app_date)->format('F j, Y') }}</td>
                            <td>
                                <div class="btn-group w-50" role="group">
                                    <button type="button" class="btn btn-outline-success me-1" 
                                            data-id="{{ $application->application_id }}" 
                                            data-status="Qualified">
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-danger" 
                                            data-id="{{ $application->application_id }}" 
                                            data-status="Not Qualified">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
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
                            <th>Candidate Name</th>
                            <th>Applied For</th>
                            <th>Resume/Curriculum Vitae (CV)</th>
                            <th>Cover Letter</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($detailedApplications as $application)
                            <tr>
                                <td>{{ $application->applicant_name }}</td>
                                <td>
                                    @if($job->job_title || $job->fl_job_title)
                                        {{ $job->job_title ?? $job->fl_job_title }}
                                    @endif
                                </td>
                                <td>
                                    @if ($application->resume_cv)
                                        <a href="{{ asset('storage/' . str_replace('public/', '', $application->resume_cv)) }}" target="_blank" download>
                                            <i class="fa-solid fa-file-arrow-down text-danger fs-3">
                                                <p class="text-dark fw-light mt-2" style="font-size: 10px;">Download Resume/CV</p>
                                            </i>
                                        </a>
                                    @else
                                        <span>No Resume</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($application->cover_letter)
                                        <a href="{{ asset('storage/' . str_replace('public/', '', $application->cover_letter)) }}" target="_blank" download>
                                            <i class="fa-solid fa-file-arrow-down text-danger fs-3">
                                                <p class="text-dark fw-light mt-2" style="font-size: 10px;">Download Cover Letter</p>
                                            </i>
                                        </a>
                                    @else
                                        <span>No Cover Letter</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('asset/js/overview-job.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- jQuery (necessary for DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script id="chartData" type="application/json">
    {!! json_encode(['daysOfWeek' => $daysOfWeek, 'applicantData' => $applicantData]) !!}
</script>
<script>
    const csrfToken = "{{ csrf_token() }}";
    const overviewJobStoreRoute = "{{ route('overview-job.store') }}";
    // Adding event listeners for both buttons
    document.querySelectorAll('#jobPostingButton, #viewHomeButton').forEach(button => {
        button.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            window.location.href = url;
        });
    });
</script>
@endsection
