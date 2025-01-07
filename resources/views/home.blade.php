@extends('layouts.app')

@section('title', 'BPO-Bridge Job Listings')

@section('home-content')
<!-- Search Bar -->
<div class="search-bar">
    <div class="container" id="search-container">
        <form action="{{ route('applicant.search') }}" method="GET">
            <div class="row mb-3">
                <!-- Keywords -->
                <div class="col-md-3 position-relative">
                    <label for="keywords" class="form-label fw-bold">Search Jobs</label>
                    <input type="text" id="keywords" name="keywords" class="form-control" placeholder="Enter Keywords" value="{{ request('keywords') }}">
                </div>

                <!-- Classification Dropdown -->
                <div class="col-md-3 position-relative">
                    <label for="classification" class="form-label fw-bold">Classifications</label>
                    <div class="dropdown d-inline w-100">
                        <button class="btn btn-outline-light dropdown-toggle w-100 text-start bg-white text-dark" type="button" id="classificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ request('category') ? $categories->firstWhere('id', request('category'))->category_name : 'Any Classification' }}
                            <span class="dropdown-icon">▼</span>
                        </button>
                        <ul class="dropdown-menu w-100" aria-labelledby="classificationDropdown">
                            <li><a class="dropdown-item" href="#" data-value="">Any Classification</a></li>
                            @foreach($categories as $category)
                            <li><a class="dropdown-item" href="#" data-value="{{ $category->category_id }}">{{ $category->category_name }}</a></li>
                            @endforeach
                        </ul>
                        <input type="hidden" name="category" id="categoryInput" value="{{ request('category') }}">
                    </div>
                </div>

                <!-- Location Dropdown -->
                <div class="col-md-3 position-relative">
                    <label for="location" class="form-label fw-bold">Locations</label>
                    <div class="dropdown d-inline w-100">
                        <button class="btn btn-outline-light dropdown-toggle w-100 text-start bg-white text-dark" type="button" id="locationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ request('location') ?? 'Select Location' }}
                            <span class="dropdown-icon">▼</span>
                        </button>
                        <ul class="dropdown-menu w-100" aria-labelledby="locationDropdown">
                            <li><a class="dropdown-item" href="#" data-value="">Any Location</a></li>
                            @foreach($locations as $location)
                            <li><a class="dropdown-item" href="#" data-value="{{ $location }}">{{ $location }}</a></li>
                            @endforeach
                        </ul>
                        <input type="hidden" name="location" id="locationInput" value="{{ request('location') }}">
                    </div>
                </div>

                <!-- Search Button -->
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-outline-dark w-100 fw-bold">Search</button>
                </div>
            </div>

            <!-- Filters -->
            <div class="row">
                <div class="col">
                    <!-- Type of Work Dropdown -->
                    <div class="dropdown d-inline">
                        <button class="btn btn-outline-light dropdown-toggle position-relative rounded-pill" type="button" id="typeOfWorkDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ request('type') === 'full_time' ? 'Full-time' : (request('type') === 'freelance' ? 'Freelance' : 'Type of work') }}
                            <span class="dropdown-icon">▼</span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="typeOfWorkDropdown">
                            <li><a class="dropdown-item" href="#" data-value="">Any Type</a></li>
                            <li><a class="dropdown-item" href="#" data-value="full_time">Full-time</a></li>
                            <li><a class="dropdown-item" href="#" data-value="freelance">Freelance</a></li>
                        </ul>
                        <input type="hidden" name="type" id="typeInput" value="{{ request('type') }}">
                    </div>

                    <!-- Salary Options Dropdown -->
                    <div class="dropdown d-inline">
                        <button class="btn btn-outline-light dropdown-toggle position-relative rounded-pill" type="button" id="salaryOptionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ request('salary') === '0-50000' ? '$0 - $50,000' : (request('salary') === '50000-100000' ? '$50,000 - $100,000' : (request('salary') === '100000+' ? '$100,000+' : 'Salary options')) }}
                            <span class="dropdown-icon">▼</span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="salaryOptionsDropdown">
                            <li><a class="dropdown-item" href="#" data-value="">Any Salary</a></li>
                            <li><a class="dropdown-item" href="#" data-value="0-50000">$0 - $50,000</a></li>
                            <li><a class="dropdown-item" href="#" data-value="50000-100000">$50,000 - $100,000</a></li>
                            <li><a class="dropdown-item" href="#" data-value="100000+">$100,000+</a></li>
                        </ul>
                        <input type="hidden" name="salary" id="salaryInput" value="{{ request('salary') }}">
                    </div>

                    <!-- Time Listed Dropdown -->
                    <div class="dropdown d-inline">
                        <button class="btn btn-outline-light dropdown-toggle position-relative rounded-pill" type="button" id="timeListedDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ request('time') === '24' ? 'Past 24 hours' : (request('time') === '168' ? 'Past week' : (request('time') === '720' ? 'Past month' : 'Time listed')) }}
                            <span class="dropdown-icon">▼</span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="timeListedDropdown">
                            <li><a class="dropdown-item" href="#" data-value="">Any Time</a></li>
                            <li><a class="dropdown-item" href="#" data-value="24">Past 24 hours</a></li>
                            <li><a class="dropdown-item" href="#" data-value="168">Past week</a></li>
                            <li><a class="dropdown-item" href="#" data-value="720">Past month</a></li>
                        </ul>
                        <input type="hidden" name="time" id="timeInput" value="{{ request('time') }}">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Job Listings -->
<div class="container mt-5">
    <h3>Available Jobs</h3>
    <div class="row job-listing">
        <!-- Loop through Full-Time Job Postings -->
        @foreach($fullTimeJobs as $job)
        <div class="col-md-6">
            <div class="job-card d-flex">
                @php
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
                    <p class="basic-pay"><i class="fa-solid fa-peso-sign me-1"></i>{{ $job->basic_pay }} per month</p>
                    <p class="job-description">{{ $job->job_description }}</p>
                    <a href="{{ route('job-info.show', ['job_info' => $job->full_job_ID, 'type' => 'full-time']) }}" class="job-link">Click for more information</a>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Loop through Freelance Job Postings -->
        @foreach($freelanceJobs as $job)
        <div class="col-md-6">
            <div class="job-card d-flex">
                @php
                $freelancePhotoPath = $job->job_photo ? asset($job->job_photo) : null;
                @endphp
                @if($freelancePhotoPath)
                <img src="{{ $freelancePhotoPath }}" alt="Company Logo" class="job-logo">
                @else
                <span>No image available</span>
                @endif
                <div class="job-details ms-3">
                    <h5 class="job-title">{{ $job->fl_job_title }}</h5>
                    <p class="job-location">{{ $job->fl_job_location }}</p>
                    <p class="job-category">{{ $categories[$job->fl_category_id]->category_name ?? 'Uncategorized' }}</p>
                    <p class="basic-pay"><i class="fa-solid fa-peso-sign me-1"></i>{{ $job->fl_basic_pay }} per month</p>
                    <p class="job-description">{{ $job->fl_job_description }}</p>
                    <a href="{{ route('job-info.show', ['job_info' => $job->fl_jobID, 'type' => 'freelance']) }}" class="job-link">Click for more information</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('applicant-scripts')
<script>
    // Handle dropdown selections
    document.querySelectorAll('.dropdown-menu a.dropdown-item').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const dropdown = this.closest('.dropdown');
            const input = dropdown.querySelector('input[type="hidden"]');
            const button = dropdown.querySelector('.dropdown-toggle');
            input.value = this.getAttribute('data-value');
            button.textContent = this.textContent;
        });
    });
</script>
@endsection