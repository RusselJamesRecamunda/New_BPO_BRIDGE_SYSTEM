@extends('layouts.app')

@section('title', 'BPO-Bridge Job Listings')

@section('content')
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="container" id="search-container">
            <div class="row mb-3"> 
                <div class="col-md-3 position-relative">
                    <label for="keywords" class="form-label fw-bold">Search Jobs</label>
                    <input type="text" id="keywords" class="form-control" placeholder="Enter Keywords">
                </div>

                <div class="col-md-3 position-relative">
                    <label for="classification" class="form-label fw-bold">Classifications</label>
                    <div class="dropdown d-inline w-100">
                        <button class="btn btn-outline-light dropdown-toggle w-100 text-start bg-white text-dark" type="button" id="classificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Any Classification
                            <span class="dropdown-icon">▼</span>
                        </button>
                        <ul class="dropdown-menu w-100" aria-labelledby="classificationDropdown">
                            <li><a class="dropdown-item" href="#">Classification 1</a></li>
                            <li><a class="dropdown-item" href="#">Classification 2</a></li>
                            <li><a class="dropdown-item" href="#">Classification 3</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-3 position-relative">
                    <label for="location" class="form-label fw-bold">Locations</label>
                    <div class="dropdown d-inline w-100">
                        <button class="btn btn-outline-light dropdown-toggle w-100 text-start bg-white text-dark" type="button" id="locationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Select Location
                            <span class="dropdown-icon">▼</span>
                        </button>
                        <ul class="dropdown-menu w-100" aria-labelledby="locationDropdown">
                            <li><a class="dropdown-item" href="#">Location 1</a></li>
                            <li><a class="dropdown-item" href="#">Location 2</a></li>
                            <li><a class="dropdown-item" href="#">Location 3</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button class="btn btn-outline-dark w-100 fw-bold">Search</button>
                </div>
            </div>

            <!-- Filters -->
            <div class="row">
                <div class="col">
                    <div class="dropdown d-inline">
                        <button class="btn btn-outline-light dropdown-toggle position-relative rounded-pill" type="button" id="typeOfWorkDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Type of work
                            <span class="dropdown-icon">▼</span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="typeOfWorkDropdown">
                            <li><a class="dropdown-item" href="#">Full-time</a></li>
                            <li><a class="dropdown-item" href="#">Part-time</a></li>
                            <li><a class="dropdown-item" href="#">Contract</a></li>
                        </ul>
                    </div>

                    <div class="dropdown d-inline">
                        <button class="btn btn-outline-light dropdown-toggle position-relative rounded-pill" type="button" id="remoteOptionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Remote options
                            <span class="dropdown-icon">▼</span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="remoteOptionsDropdown">
                            <li><a class="dropdown-item" href="#">Remote</a></li>
                            <li><a class="dropdown-item" href="#">On-site</a></li>
                            <li><a class="dropdown-item" href="#">Hybrid</a></li>
                        </ul>
                    </div>

                    <div class="dropdown d-inline">
                        <button class="btn btn-outline-light dropdown-toggle position-relative rounded-pill" type="button" id="salaryOptionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Salary options
                            <span class="dropdown-icon">▼</span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="salaryOptionsDropdown">
                            <li><a class="dropdown-item" href="#">$0 - $50,000</a></li>
                            <li><a class="dropdown-item" href="#">$50,000 - $100,000</a></li>
                            <li><a class="dropdown-item" href="#">$100,000+</a></li>
                        </ul>
                    </div>

                    <div class="dropdown d-inline">
                        <button class="btn btn-outline-light dropdown-toggle position-relative rounded-pill" type="button" id="timeListedDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Time listed
                            <span class="dropdown-icon">▼</span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="timeListedDropdown">
                            <li><a class="dropdown-item" href="#">Past 24 hours</a></li>
                            <li><a class="dropdown-item" href="#">Past week</a></li>
                            <li><a class="dropdown-item" href="#">Past month</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Job Listings -->
    <div class="container mt-5">
        <h3>Available Jobs</h3>
        <div class="row job-listing">
             <!-- Job Cards -->
             <!-- Loop through Full-Time Job Postings -->
             @foreach($fullTimeJobs as $job)
                <div class="col-md-6">
                    <div class="job-card d-flex">
                        @php
                        // Accessing Full-Time Job Photo
                        $fullTimePhotoPath = $job->job_photo ? asset($job->job_photo) : null; 
                        @endphp
                        @if($fullTimePhotoPath)
                            <img src="{{ $fullTimePhotoPath }}" alt="Company Logo" class="job-logo">
                        @else
                            <span>No image available</span>
                        @endif 
                        <div class="job-details ms-3">
                            <h5 class="job-title">{{ $job->job_title }}</h5>
                            <p class="job-location">{{ $job->job_location }}</p>
                            <p class="job-category">{{ $categories[$job->category_id]->category_name ?? 'Uncategorized' }}</p>
                            <p class="basic-pay"><i class="fa-solid fa-peso-sign me-1"></i>{{ $job->basic_pay }}  per month</p>
                            <p class="job-description">{{ $job->job_description }}</p>
                            <p class="job-posted">{{ $job->creation_date->diffForHumans() }}</p>
                            <a href="{{ route('job-info.show', ['job_info' => $job->full_job_ID, 'type' => 'full-time']) }}" class="job-link">Click for more information</a>
                        </div>
                    </div>
                </div>
            @endforeach
            
            <!-- Freelance Job Postings -->
            @foreach($freelanceJobs as $job)
                <div class="col-md-6">
                    <div class="job-card d-flex">
                        @php
                        // Accessing Freelance Job Photo
                        $freelancePhotoPath = $job->job_photo ? asset($job->job_photo) : null; 
                        @endphp
                        @if($freelancePhotoPath)
                            <img src="{{ $freelancePhotoPath }}" alt="Company Logo" class="job-logo">
                        @else
                            <span>No image available</span>
                        @endif
                        <div class="job-details ms-3">
                            <h5 class="job-title">{{ $job->fl_job_title  }}</h5>
                            <p class="job-location">{{ $job->fl_job_location }}</p>
                            <p class="job-category">{{ $categories[$job->fl_category_id]->category_name ?? 'Uncategorized' }}</p>
                            <p class="basic-pay"><i class="fa-solid fa-peso-sign me-1"></i>{{ $job->fl_basic_pay }} per month</p>
                            <p class="job-description">{{ $job->fl_job_description }}</p>
                            <p class="job-posted">{{ $job->creation_date->diffForHumans() }}</p>
                            <a href="{{ route('job-info.show', ['job_info' => $job->fl_jobID, 'type' => 'freelance']) }}" class="job-link">Click for more information</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div> 
    </div>
@endsection

@section('applicant-scripts')
<script src="{{ asset('asset/js/home.js') }}"></script>
@endsection
