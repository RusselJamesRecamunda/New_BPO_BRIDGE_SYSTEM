@extends('layouts.admin_pages')

@section('title', 'Jobs')

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

    </style>
@endsection

@section('jobs-content')
        <!-- Top Bar -->
        @include('components.topbar')

        <div class="mb-4">
            <!-- Search and Button Row -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="custom-search-bar">
                        <input type="text" placeholder="Search">
                        <button type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                <button class="btn btn-primary" type="button" data-url="{{ route('job-posting.index') }}" id="jobPostingButton""><i class="fa-solid fa-circle-plus me-2"></i>Post New Job</button>
            </div>
        </div>
          
        <!-- Job Cards Display -->
        <div class="row">
    <!-- Loop through Full-Time Job Postings -->
    @foreach($fullTimeJobs as $job)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <img src="{{ asset('storage/uploads/job-postings/' . ($job->job_photo ?? 'default.jpg')) }}" alt="Company Logo" style="width: 50px;">
                        <div>
                            <h5 class="card-title">{{ $job->job_title }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $job->job_title }}</h6>
                        </div>
                    </div>
                    <p class="card-text">
                        ${{ $job->basic_pay }}
                    </p>
                    <p class="card-text">
                        {{ Str::limit($job->job_description, 100, '...') }}
                    </p>
                    <p class="card-text">
                        Opening Jobs (0/{{ $job->max_hires }})
                    </p>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-primary" style="width: 0%;"></div>
                    </div>
                    <a href="#" class="btn btn-primary">View Applications</a>
                    <p class="text-muted mt-2">
                        <small><i class="fas fa-map-marker-alt"></i> {{ $job->job_location }}</small>
                    </p>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row">
    <!-- Loop through Freelance Job Postings -->
    @foreach($freelanceJobs as $job)
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <img src="{{ asset('storage/uploads/job-postings/' . ($job->fl_job_photo ?? 'default.jpg')) }}" alt="Company Logo" style="width: 50px;">
                        <div>
                            <h5 class="card-title">{{ $job->fl_job_title }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $job->fl_job_title }}</h6>
                        </div>
                    </div>
                    <p class="card-text">
                        ${{ $job->fl_basic_pay }}
                    </p>
                    <p class="card-text">
                        {{ Str::limit($job->fl_job_description, 100, '...') }}
                    </p>
                    <p class="card-text">
                        Opening Jobs (0/{{ $job->max_hires }})
                    </p>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-primary" style="width: 0%;"></div>
                    </div>
                    <a href="#" class="btn btn-primary">View Applications</a>
                    <p class="text-muted mt-2">
                        <small><i class="fas fa-map-marker-alt"></i> {{ $job->fl_job_location }}</small>
                    </p>
                </div>
            </div>
        </div>
    @endforeach
</div>



    </div> 
</div>
@endsection

@section('scripts')
<script>
      document.getElementById('jobPostingButton').addEventListener('click', function() {
        var url = this.getAttribute('data-url');
        window.location.href = url;
    });
</script>
@endsection
