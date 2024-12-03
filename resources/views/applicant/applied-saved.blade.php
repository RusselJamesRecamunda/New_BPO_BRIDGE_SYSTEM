@extends('layouts.applicant_pages')

@section('title', 'Job Applications')

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/applied-saved.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
@endsection

@section('applied-saved-content') 
<!-- Job Activity Section -->
<div class="job-activity container mt-4">
    <!-- Tabs for Saved and Applied Jobs -->
    <!-- Dynamic Header -->
    <h3 id="sectionHeader" class="text-left ps-3">Saved Jobs</h3>
    <div class="text-left mb-4">
        <button id="appliedTab" class="tab-button" onclick="showSection('applied')">
            <i class="fas fa-check-circle me-2"></i>Applied
        </button> 
        <button id="savedTab" class="tab-button active" onclick="showSection('saved')">
            <i class="fas fa-bookmark me-2"></i>Saved
        </button>
    </div>

   <!-- Saved Jobs Section -->
    <div id="savedJobs" class="job-section active">
        <div class="d-flex flex-column align-items-center">
            @if($savedJobs->isEmpty())
                <br>
                <h5 class="text-center"><i class="fa-solid fa-briefcase me-2"></i>No saved jobs yet.</h5>
            @else
            @foreach($savedJobs as $savedJob)
                <div class="job-card p-3 border mb-4 position-relative">
                    @if($savedJob->job_type_name == 'full-time' && $savedJob->fullTimeJob)
                        @php
                            $job = $savedJob->fullTimeJob;
                        @endphp
                    @elseif($savedJob->job_type_name == 'freelance' && $savedJob->freelanceJob)
                        @php
                            $job = $savedJob->freelanceJob;
                        @endphp
                    @else
                        @php $job = null; @endphp
                    @endif
                    
                    @if($job)
                    <!-- Ellipsis Icon Positioned at the Top Right of the Job Card -->
                        <div class="dropdown">
                            <a href="#" class="text-dark position-absolute end-0 me-3" style="font-size: 25px; top: -7px;" 
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis"></i>
                            </a>
                            <ul class="dropdown-menu" style="padding: 5px; text-align: center; width: auto; min-width: unset;">
                                <li>
                                <button class="dropdown-item text-danger" style="padding: 5px 10px;"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal"
                                        data-save-id="{{ $savedJob->save_ID }}">
                                    Delete Job
                                </button>
                                </li>
                            </ul>
                        </div>

                        <!-- Delete Confirmation Modal -->
                        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-sm">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Delete Job</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you would like to delete this job from your saved jobs list?
                                    </div>
                                    <div class="modal-footer justify-content-start">
                                        <button type="button" class="btn btn-danger" id="confirmDeleteButton"><i class="fa-solid fa-trash me-2"></i>Delete</button>
                                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        <div class="d-flex">
                            <div class="job-details ms-3">
                                <h5 class="job-title">
                                    <a href="{{ route('job-info.show', ['job_info' => $job->full_job_ID ?? $job->fl_jobID, 'type' => $savedJob->job_type_name]) }}" class="job-link">
                                        {{ $job->job_title ?? $job->fl_job_title }}
                                    </a>
                                </h5>
                                
                                <!-- Access the category correctly -->
                                @if($savedJob->job_type_name == 'full-time' && $job->category)
                                    <p class="job-category">{{ $job->category->category_name ?? 'Uncategorized' }}</p>
                                @elseif($savedJob->job_type_name == 'freelance' && $job->category)
                                    <p class="job-category">{{ $job->category->category_name ?? 'Uncategorized' }}</p>
                                @else
                                    <p class="job-category">Uncategorized</p>
                                @endif

                                <p class="job-posted"><i class="fa-regular fa-clock me-2"></i>Posted {{ $job->creation_date->diffForHumans() }}</p>
                                <p class="job-location"><i class="fa-solid fa-location-dot me-2"></i>{{ $job->job_location ?? $job->fl_job_location }}</p>
                                <p class="job-description">{{ $job->job_description ?? $job->fl_job_description }}</p>
                                    @if (session('error'))
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function () {
                                                alert("{{ session('error') }}");
                                            });
                                        </script>
                                    @endif
                                <a href="{{ route('application-form.show', ['application_form' => $job->full_job_ID ?? $job->fl_jobID, 'type' => $job->full_job_ID ? 'full-time' : 'freelance']) }}"  
                                class="btn btn-primary"
                                data-job-type="{{ $job->full_job_ID ? 'full-time' : 'freelance' }}"
                                data-job-title="{{ $job->job_title ?? $job->fl_job_title }}">
                                    Apply
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
            @endif
        </div>
    </div>


        <!-- Applied Jobs Section -->
    <div id="appliedJobs" class="job-section">
        @foreach($appliedJobs as $job)
            <div class="d-flex flex-column align-items-center">
                <div class="job-card p-3 border mb-4">
                    <!-- Ellipsis Icon Positioned at the Top Right of the Job Card -->
                    <div class="dropdown">
                        <a href="#" class="text-dark position-absolute end-0 me-1" style="font-size: 25px; top: -7px;" 
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-ellipsis"></i>
                        </a>
                        <ul class="dropdown-menu" style="padding: 5px; text-align: center; width: auto; min-width: unset;">
                            <li>
                                <button class="dropdown-item text-danger" style="padding: 5px 10px;" data-bs-toggle="modal" data-bs-target="#deleteApplicationModal">
                                    Delete Job Application
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Delete Confirmation Modal -->
                    <div class="modal fade" id="deleteApplicationModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel">Delete Job</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    This application will be permanently deleted from your list only, your application remains to be processed.
                                </div>
                                <div class="modal-footer justify-content-start">
                                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn"><i class="fa-solid fa-trash me-2"></i>Delete</button>
                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="job-title">
                        <a href="{{ route('job-info.show', ['job_info' => $job->fullTimeJobPosting->full_job_ID ?? $job->freelanceJobPosting->fl_jobID, 'type' => $job->job_type_name]) }}" class="job-link">
                            {{ $job->fullTimeJobPosting->job_title ?? $job->freelanceJobPosting->fl_job_title }}
                        </a>
                    </h5>
                    <p class="job-category">{{ $job->job_category }}</p>
                    <p class="job-location"><i class="fa-solid fa-location-dot me-2"></i>{{ $job->fullTimeJobPosting->job_location ?? $job->freelanceJobPosting->fl_job_location }}</p>
                    <p class="text-success">
                        <i class="fas fa-check-circle me-2"></i>
                        Applied on {{ \Carbon\Carbon::parse($job->app_date)->format('F d, Y') }}
                    </p>
                    <p>Status: {{ $job->application_status }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection

@section('jobapplication-scripts')
<script src="{{ asset('asset/js/applied-saved.js') }}"></script>
<script>
    window.applicantUrls = {
        deleteUrl: "{{ url('applicant/applied-saved') }}" // Pass the URL to a global JS object
    };
</script>
@endsection
