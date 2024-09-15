@extends('layouts.admin_pages')

@section('title', 'Job Details')

@section('styles')
    <!-- Add additional styles specific to this view here -->
    <link rel="stylesheet" href="{{ asset('asset/css/job_posting.css') }}">
@endsection

@section('job-posting-content')
        <!-- Top Bar -->
        @include('components.topbar')

        <h2 class="mb-3 text-primary"><i class="fa-solid fa-pen-to-square me-3"></i>Job Posting Section</h2>
            <!-- Job Posting Form -->
            <div class="container p-4 mt-3 mb-3 bg-light" style="border-radius: 10px;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0 flex-shrink-1">Post New Job Details</h2>
                    <div class="flex-shrink-0" style="max-width: 150px; margin: -40px 0 -50px 0;">
                        <img src="{{ asset('asset/img/bpo_logo.png') }}" alt="BPO Logo" class="img-fluid">
                    </div>
                </div>
                <form>
                    <div class="row mb-3">
                        <!-- Title -->
                        <div class="col-md-6">
                            <label for="jobTitle" class="form-label fw-bold" style="font-family: 'Poppins', sans-serif;">
                                Job Title <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="jobTitle" placeholder="Enter job title" required>
                        </div>
                        <!-- Select Category -->
                        <div class="col-md-6">
                            <label for="jobCategory"  class="form-label fw-bold" style="font-family: 'Poppins', sans-serif;">
                                Category <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="jobCategory" required>
                                <option selected>Select category</option>
                                <option value="1">IT</option>
                                <option value="2">Finance</option>
                                <option value="3">Healthcare</option>
                                <!-- Add more categories as needed -->
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <!-- Select Job Type -->
                        <div class="col-md-6">
                            <label for="jobType" class="form-label fw-bold" style="font-family: 'Poppins', sans-serif;">
                                Job Type <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="jobType" required>
                                <option selected>Select job type</option>
                                <option value="1">Full-time</option>
                                <option value="2">Freelance</option>
                            </select>
                        </div>
                        <!-- Vacancy -->
                        <div class="col-md-6">
                            <label for="vacancyInput" class="form-label fw-bold" style="font-family: 'Poppins', sans-serif;">
                                Vacancy <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control" id="vacancyInput" placeholder="Enter number of vacancies" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <!-- Basic Pay -->
                        <div class="col-md-6">
                            <label for="basicPayInput" class="form-label fw-bold" style="font-family: 'Poppins', sans-serif;">Basic Pay</label>
                            <input type="number" class="form-control" id="basicPayInput" placeholder="Enter basic pay amount">
                        </div>
                        <!-- Job Location -->
                        <div class="col-md-6">
                            <label for="jobLocationInput" class="form-label fw-bold" style="font-family: 'Poppins', sans-serif;">
                                Job Location <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="jobLocationInput" placeholder="Enter job location" required>
                        </div>
                    </div>
                    <!-- Job Description -->
                    <div class="mb-3">
                        <label for="jobDescriptionInput" class="form-label fw-bold" style="font-family: 'Poppins', sans-serif;">
                            Job Description <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" id="jobDescriptionInput" rows="10" placeholder="Enter job description" required></textarea>
                    </div>
                    <!-- Company Benefits -->
                    <div class="mb-3">
                        <label for="companyBenefitsinput" class="form-label fw-bold" style="font-family: 'Poppins', sans-serif;">Company Benefits</label>
                        <textarea class="form-control" id="companyBenefitsinput" rows="10" placeholder="Enter Company Benefits"></textarea>
                    </div>
                    <!-- Requirements -->
                    <div class="mb-3">
                        <label for="Requirementsinput" class="form-label fw-bold" style="font-family: 'Poppins', sans-serif;">
                            Requirements <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" id="Requirementsinput" rows="10" placeholder="Enter Requirements" required></textarea>
                    </div>

                    <div class="row mb-3">
                        <!-- Select Job Experience -->
                        <div class="col-md-4">
                            <label for="Experience" class="form-label fw-bold" style="font-family: 'Poppins', sans-serif;">
                                Experience <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="jobType" required>
                                <option selected>Select Experience</option>
                                <option value="1">N/A</option>
                                <option value="2">1 Years</option>
                                <option value="3">2 Years</option>
                                <option value="4">3 Years</option>
                                <option value="5">4 Years</option>
                                <option value="6">5 Years</option>
                                <option value="7">6 Years</option>
                                <option value="8">7 Years</option>
                                <option value="9">8 Years</option>
                                <option value="10">9 Years</option>
                                <option value="11">10 Years</option>
                                <option value="12">More than 10 Years</option>
                            </select>
                        </div>
                        <!-- Company Department -->
                        <div class="col-md-5">
                            <label for="corpDeptInput" class="form-label fw-bold" style="font-family: 'Poppins', sans-serif;">
                                Company Department <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="corpDeptInput" placeholder="Enter Company Department" required>
                        </div>
                        <!-- Keywords -->
                        <div class="col-md-3">
                            <label for="Keywords" class="form-label fw-bold" style="font-family: 'Poppins', sans-serif;">Keywords</label>
                            <input type="text" class="form-control" id="Keywords" placeholder="Enter Keywords">
                        </div>
                    </div>
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-custom">
                        Post Job Details <i class="fa-solid fa-arrow-up-from-bracket"></i>
                    </button>
                </form>
            </div>
@endsection

@section('scripts')
    
@endsection
