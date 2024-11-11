@extends('layouts.applicant_pages')

@section('title', 'Job Information')

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/job-info.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection

@section('job-info-content')
 <!-- Job Posting Section -->
 <div class="job-posting">
        <div class="header">
            <h2>{{ $job->job_title ?? $job->fl_job_title }}</h2>
        </div>

        @if($job->job_title || $job->fl_job_title)
            <div class="role-section">
                <h3>Your Role as a {{ $job->job_title ?? $job->fl_job_title }}</h3>
                <p>{!! $job->job_description ?? $job->fl_job_description !!}</p>
            </div>
        @endif

        @if($job->requirements || $job->fl_requirements)
            <div class="requirements-section">
                <h3>Requirements:</h3>
                {!! $job->requirements ?? $job->fl_requirements !!}
            </div>
        @endif

        @if($job->company_benefits || $job->fl_company_benefits)
            <div class="benefits-section">
                <h3>What should you expect from us?</h3>
                <p>{!! $job->company_benefits ?? $job->fl_company_benefits !!}</p>
            </div>
        @endif

        <div class="footer">
            <div class="icon">
                <img src="{{ asset('asset/img/applicant/typework.png') }}" alt="Full Time">
                <span>{{ $job->jobType->job_type_name ?? 'Unknown Job Type' }}</span> <!-- Check for jobType -->
            </div>
            <div class="icon">
                <img src="{{ asset('asset/img/applicant/work.png') }}" alt="Customer Service - Call Centre">
                <span>{{ $job->category->category_name ?? 'Unknown Category' }}</span> <!-- Check for category -->
            </div>
            <div class="icon">
                <img src="{{ asset('asset/img/applicant/building.png') }}" alt="On-site">
                <span>{{ $job->job_location ?? $job->fl_job_location }}</span>
            </div>
            <div class="icon">
                <img src="{{ asset('asset/img/applicant/salary.png') }}" alt="18k - 20k">
                <span><i class="fa-solid fa-peso-sign"></i> {{ $job->basic_pay ?? $job->fl_basic_pay }}</span>
            </div>
        </div>

        <div class="call-to-action">
            <p>Ready to Start Your Journey?</p>
            <p style="margin-bottom: 20px">Apply now and take the first step towards a fulfilling career at <strong>BPO-BRIDGE™</strong>.</p>
            
            @auth
                <a href="{{ route('application-form.show', ['application_form' => $job->full_job_ID ?? $job->fl_jobID, 'type' => $job->full_job_ID ? 'full-time' : 'freelance']) }}" class="apply-btn text-decoration-none">Apply Now<i class="fa-solid fa-arrow-up-right-from-square ms-2"></i></a>
            @else
                <button 
                    class="apply-btn" 
                    data-bs-toggle="modal" 
                    data-bs-target="#loginModal"
                    data-job-type="{{ $job->full_job_ID ? 'full-time' : 'freelance' }}"
                    data-job-title="{{ $job->job_title ?? $job->fl_job_title }}">
                    Apply Now<i class="fa-solid fa-arrow-up-right-from-square ms-2"></i>
                </button>
            @endauth

            <p class="application-deadline">Application ends in: <span id="countdown">3 days</span></p>
            <p>Unsure yet? Click Save to get back to it later.</p>
            <button class="save-btn">Save<i class="fa-regular fa-bookmark ms-2"></i></button>
        </div>
    </div>    

    <!-- Modal for Login/Signup If Restricted to Apply Job-->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header justify-content-center">
                    <h5 class="modal-title text-center" id="loginModalLabel"></h5>
                    <button type="button" class="btn-close position-absolute end-0 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <p class="mb-4">You need to log in or sign up to apply for this job.</p>
                    <div class="d-flex justify-content-center gap-4">
                        <a href="{{ route('login') }}" class="btn btn-outline-primary px-4">Log In</a>
                        <a href="{{ route('register') }}" class="btn btn-outline-primary px-4">Sign Up</a>
                    </div>
                    <p class="mt-3 text-muted">Sign in to manage your profile, save searches, and view recommended jobs.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const loginModal = document.getElementById('loginModal');
        
        loginModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const jobType = button.getAttribute('data-job-type');
            const jobTitle = button.getAttribute('data-job-title');
            const modalTitle = loginModal.querySelector('.modal-title');
            
            modalTitle.innerHTML = `Applying for: ${jobTitle} (${jobType.charAt(0).toUpperCase() + jobType.slice(1)})`;
        });
    });
</script>
@endsection