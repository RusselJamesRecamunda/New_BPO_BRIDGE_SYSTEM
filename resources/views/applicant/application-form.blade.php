@extends('layouts.application-form_page')

@section('title', 'BPO Job Application Form')

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/application-form.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
@endsection

@section('application-content')
      <!-- Application Form -->
      <div class="container">
        <div class="form-container">
            <div class="form-title">
                @if ($jobType === 'full-time')
                    Applying for: {{ $job->job_title }}
                @elseif ($jobType === 'freelance')
                    Applying for: {{ $job->fl_job_title }}
                @else
                    <p>Invalid job type</p>
                @endif
            </div>

            <form action="{{ route('application-form.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="jobType" value="{{ $jobType }}">
                    <input type="hidden" name="jobId" value="{{ $job->full_job_ID ?? $job->fl_jobID }}">
               
                <div class="row mb-3">
                    <div class="col">
                        <label for="firstName" class="form-label">First Name <span class="text-danger">*</span></label>
                        <input type="text" name="firstName" id="firstName" class="form-control" required>
                        <div class="error-message" id="firstNameError">First Name cannot be empty.</div>
                    </div>
                    <div class="col">
                        <label for="lastName" class="form-label">Last Name <span class="text-danger">*</span></label>
                        <input type="text" name="lastName" id="lastName" class="form-control" required>
                        <div class="error-message" id="lastNameError">Last Name cannot be empty.</div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control" required>
                        <div class="error-message" id="emailError">Email cannot be empty.</div>
                    </div>
                    <div class="col">
                        <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                        <input type="tel" name="phone" id="phone" class="form-control" required>
                        <div class="error-message" id="phoneError">Phone cannot be empty.</div>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col">
                        <label for="address" class="form-label">Home Address <span class="text-danger">*</span></label>
                        <input type="address" name="address" id="address" class="form-control" required>
                        <div class="error-message" id="addressError">Address cannot be empty.</div>
                    </div>
                </div>

                
                <div class="mb-3">
                    <label class="form-label">What is your current employment status? <span class="text-danger">*</span></label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="employmentStatus" id="employed" value="Employed" required>
                            <label class="form-check-label" for="employed">Employed</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="employmentStatus" id="unemployed" value="Unemployed" required>
                            <label class="form-check-label" for="unemployed">Unemployed</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="employmentStatus" id="selfEmployed" value="Self-Employed" required>
                            <label class="form-check-label" for="selfEmployed">Self-Employed</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="employmentStatus" id="student" value="Student" required>
                            <label class="form-check-label" for="student">Student</label>
                        </div>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Resume: <span class="text-danger">*</span></label>
                    <div class="file-upload" onclick="document.getElementById('resume').click()">
                        <img src="{{ asset('asset/img/applicant/upload.png') }}" alt="Upload Icon" class="upload-icon">
                        <p>Upload a File<br><small>Drag and drop files here</small></p>
                        <input type="file" name="resume" id="resume" accept=".pdf" required style="display: none;">
                    </div>
                    <div class="uploaded-file-name" id="resumeFileName"></div>
                    <div class="note">Note: File should be in PDF format.</div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Cover Letter:</label>
                    <div class="file-upload" onclick="document.getElementById('coverLetter').click()">
                        <img src="{{ asset('asset/img/applicant/upload.png') }}" alt="Upload Icon" class="upload-icon">
                        <p>Upload a File<br><small>Drag and drop files here</small></p>
                        <input type="file" name="coverLetter" id="coverLetter" accept=".pdf" style="display: none;">
                    </div>
                    <div class="uploaded-file-name" id="coverLetterFileName"></div>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-secondary">Reset</button>
                </div>
                
                <!-- Confirmation Modal -->
                <div id="confirmationModal" class="modal">
                    <div class="modal-content">
                        <p>Thank you for applying, please wait for our email for further information.</p>
                        <button id="modalOkButton" class="apply-btn">OK</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection 

@section('applicant-scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('asset/js/application-form.js') }}"></script>
@endsection
