@extends('layouts.admin_pages')

@section('title', 'Jobs')

@section('browser-icon')
    <link rel="icon" href="{{ asset('asset/img/browser-icons/bpo_icon.png') }}" type="image/x-icon">
@endsection

@section('styles')
    <!-- Add additional styles specific to this view here -->
    <link rel="stylesheet" href="{{ asset('asset/css/shares.css') }}">
    <style>
        .btn-primary {
            background-color: #0F5078;
            border: none;
            padding: 10px 20px;
            font-weight: bold;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0C3E5A;
        }
        .row {
            margin: -1%;
        }

        .col-lg-4, .col-md-6 {
            padding: 10px;
        }

        .card {
            height: 100%;
        }

          /* Container with background color */
  .all-jobs-container {
    background-color: #D9D9D9;
    padding: 20px;
    border-radius: 8px;
    height: 193vh; /* Ensure this height is dynamic based on viewport or desired fixed size */
    overflow-y: auto; /* Enable vertical scrolling */
    overflow-x: hidden; /* Prevent horizontal scrolling */
    scrollbar-width: none; /* Hide scrollbar for Firefox */
    -ms-overflow-style: none; /* Hide scrollbar for IE/Edge */
}

/* Hide scrollbar for WebKit-based browsers (Chrome, Safari, etc.) */
.all-jobs-container::-webkit-scrollbar {
    display: none;
}
    </style>
@endsection

@section('jobs-content')
    <!-- Top Bar -->
    @include('components.topbar')

<div class="all-jobs-container mb-4">
   <!-- Job Cards Display -->
    <div class="row">
        <!-- Loop through Full-Time Job Postings -->
        @foreach($fullTimeJobs as $job)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between mb-3">
                        @php
                            // Accessing Full-Time Job Photo
                            $fullTimePhotoPath = $job->job_photo ? asset($job->job_photo) : null; 
                        @endphp
                        @if($fullTimePhotoPath)
                            <img src="{{ $fullTimePhotoPath }}" alt="Company Logo" style="width: 100px;">
                        @else
                            <span>No image available</span>
                        @endif 
                            <div>
                                <h5 class="card-title">{{ $job->job_title }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">{{ $categories[$job->category_id]->category_name ?? 'Uncategorized' }}</h6>
                            </div>
                        </div>
                        <p class="card-text">PHP {{ $job->basic_pay }}</p>
                        <p class="card-text">{!! Str::limit($job->job_description, 100, '...') !!}</p>
                        <p class="job-posted">{{ $job->creation_date->diffForHumans() }}</p>
                        <p class="card-text fw-bold">Opening Jobs (0/{{ $job->max_hires }})</p>
                        <div class="progress mb-3">
                            <div class="progress-bar bg-primary" style="width: 0%;"></div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <button class="btn btn-primary" type="button" data-url="{{ route('overview-job.show', ['overview_job' => $job->full_job_ID, 'type' => 'full-time']) }}" id="overviewButton">
                            <i class="fa-solid fa-eye me-2"></i>View Job
                            </button>
                            <p class="text-muted mb-0">
                                <small><i class="fas fa-map-marker-alt"></i> {{ $job->job_location }}</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="row">
        <!-- Loop through Freelance Job Postings -->
        @foreach($freelanceJobs as $job)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between mb-3">
                        @php
                            // Accessing Freelance Job Photo
                            $freelancePhotoPath = $job->job_photo ? asset($job->job_photo) : null; 
                        @endphp
                        @if($freelancePhotoPath)
                            <img src="{{ $freelancePhotoPath }}" alt="Company Logo" style="width: 50px;">
                        @else 
                            <span>No image available</span>
                        @endif
                            <div>
                                <h5 class="card-title">{{ $job->fl_job_title }}</h5>
                                <h6 class="card-subtitle mb-2 text-muted">{{ $categories[$job->fl_category_id]->category_name ?? 'Uncategorized' }}</h6>
                            </div>
                        </div>
                        <p class="card-text">PHP {{ $job->fl_basic_pay }}</p>
                        <p class="card-text">{{ Str::limit($job->fl_job_description, 100, '...') }}</p>
                        <p class="card-text fw-bold">Opening Jobs (0/{{ $job->max_hires }})</p>
                        <div class="progress mb-3">
                            <div class="progress-bar bg-primary" style="width: 0%;"></div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <button class="btn btn-primary" type="button" data-url="{{ route('overview-job.show', ['overview_job' => $job->fl_jobID, 'type' => 'freelance']) }}" id="overviewButton">
                            <i class="fa-solid fa-eye me-2"></i>View Job
                            </button>
                            <p class="text-muted mt-2">
                                <small><i class="fas fa-map-marker-alt"></i> {{ $job->fl_job_location }}</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Adding event listeners for both buttons
    document.querySelectorAll('#jobPostingButton, #overviewButton').forEach(button => {
        button.addEventListener('click', function() {
            const url = this.getAttribute('data-url');
            window.location.href = url;
        });
    });
</script>
@endsection
