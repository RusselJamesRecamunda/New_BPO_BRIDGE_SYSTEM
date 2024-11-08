
@extends('layouts.admin_pages')

@section('title', 'Job Details')

@section('styles')
    <!-- Add additional styles specific to this view here -->
    <link rel="stylesheet" href="{{ asset('asset/css/job_posting.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        /* Custom Flatpickr Styles */
.flatpickr-calendar {
    border: 1px solid #ddd;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
}

.flatpickr-day.today {
    color: #007bff;
    font-weight: bold;
}

.flatpickr-day.selected {
    background-color: #007bff;
    color: #fff;
}

.flatpickr-day:hover, .flatpickr-day:focus {
    background-color: #007bff20;
    color: #007bff;
}

.flatpickr-month {
    font-weight: bold;
}

.flatpickr-weekday {
    color: #333;
}

.flatpickr-monthDropdown-months, .flatpickr-next-month, .flatpickr-prev-month {
    color: #007bff;
}

.flatpickr-day.disabled, .flatpickr-day.nextMonthDay, .flatpickr-day.prevMonthDay {
    color: #ccc;
}

button.flatpickr-clear, button.flatpickr-close {
    color: #dc3545;
}

/* Ensure the input fields have a visible border and no white hover effect */
.input-group .form-control {
    border: 1px solid #ced4da; /* Border color */
    box-shadow: none; /* Remove any unwanted shadow effect */
}

.input-group .form-control:focus {
    border-color: #80bdff; /* Border color on focus */
    box-shadow: 0 0 0 0.25rem rgba(38, 143, 255, 0.5); /* Add focus shadow */
}

.input-group .input-group-text {
    background-color: #fff; /* Ensure the background of the calendar icon is not white */
    border: 1px solid #ced4da; /* Match the border color of the input field */
}

.input-group .form-control:focus + .input-group-text {
    border-color: #80bdff; /* Make sure the calendar icon's border color changes on focus */
}


    </style>
@endsection
 
@section('job-posting-content')
        <!-- Top Bar -->
        @include('components.topbar')

        <h2 class="mb-3 text-primary"><i class="fa-solid fa-pen-to-square me-3" ></i>Job Posting Section</h2>
            <!-- Job Posting Form -->
            <div class="container p-4 mt-3 mb-3 bg-light" style="border-radius: 10px; height: 187vh; overflow-y: auto;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0 flex-shrink-1">Post New Job Details</h2>
                    <div class="flex-shrink-0" style="max-width: 150px; margin: -50px -15px -40px 0;">
                        <img src="{{ asset('asset/img/bpo_logo.png') }}" alt="BPO Logo" class="img-fluid">
                    </div>
                </div>


                <!-- Display errors if any -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Display success message if available -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
                <form action="{{ route('job-posting.store') }}" method="post" enctype="multipart/form-data" id="jobPostingForm" name="jobPostingForm">
                @csrf
                    <div class="row mb-3">
                        <!-- Title -->
                        <div class="col-md-6">
                            <label for="jobTitle" class="form-label fw-bold" style="font-family: 'Poppins', sans-serif;">
                                Job Title <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control @error('job_title') is-invalid @enderror" id="job_title" name="job_title" value="{{ old('job_title') }}" placeholder="Enter job title" required>
                            @error('job_title')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                      <!-- Select Category -->
                        <div class="col-md-6">
                            <label for="jobCategory" class="form-label fw-bold" style="font-family: 'Poppins', sans-serif;">
                                Category <span class="text-danger">*</span>
                            </label> 

                            <select class="form-select" id="jobCategory" name="jobCategory" required>
                                    <option selected>Select category</option>
                                    @if (isset($categories) && $categories->isNotEmpty())
                                        @foreach ($categories as $jobCategory)
                                            <option value="{{  $jobCategory->category_id }}">{{  $jobCategory->category_name }}</option>
                                        @endforeach
                                    @else
                                        <option disabled>No categories available</option>
                                    @endif
                            </select>
                        </div>

                    </div>
                    <div class="row mb-3"> 
                        <!-- Select Job Type -->
                        <div class="col-md-6">
                            <label for="jobType" class="form-label fw-bold" style="font-family: 'Poppins', sans-serif;">
                                Job Type <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="jobType" name="jobType" required>
                                <option selected>Select job type</option>
                                @if (isset($jobTypes) && $jobTypes->isNotEmpty())
                                    @foreach ($jobTypes as $jobType)
                                        <option value="{{ $jobType->job_type_id }}">{{ $jobType->job_type_name }}</option>
                                    @endforeach
                                @else
                                    <option disabled>No job types available</option>
                                @endif
                            </select>
                        </div>
                        <!-- Vacancy -->
                        <div class="col-md-6">
                            <label for="vacancyInput" class="form-label fw-bold" style="font-family: 'Poppins', sans-serif;">
                                Vacancy <span class="text-danger">*</span>
                            </label>
                            <input type="number" class="form-control" id="max_hires" name="max_hires" placeholder="Enter number of vacancies" required>
                        </div>
                    </div>
                    <div class="row mb-3">  
                        <!-- Basic Pay -->
                        <div class="col-md-6">
                            <label for="basicPayInput" class="form-label fw-bold" style="font-family: 'Poppins', sans-serif;">
                            Basic Pay</label>
                            <input type="text" class="form-control" id="basic_pay" name="basic_pay" placeholder="Enter Basic Pay">
                        </div>
                        <!-- Job Location -->
                        <div class="col-md-6">
                            <label for="jobLocationInput" class="form-label fw-bold" style="font-family: 'Poppins', sans-serif;">
                                Job Location <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="job_location" name="job_location" placeholder="Enter job location" required>
                        </div>
                    </div>
                    <!-- Job Description -->
                    <div class="mb-3">
                        <label for="jobDescriptionInput" class="form-label fw-bold" style="font-family: 'Poppins', sans-serif;">
                            Job Description <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" id="job_description" name="job_description" rows="10" placeholder="Enter job description" required></textarea>
                    </div>
                    <!-- Company Benefits -->
                    <div class="mb-3">
                        <label for="companyBenefitsinput" class="form-label fw-bold" style="font-family: 'Poppins', sans-serif;">Company Benefits</label>
                        <textarea class="form-control" id="company_benefits" name="company_benefits" rows="10" placeholder="Enter Company Benefits"></textarea>
                    </div>
                    <!-- Requirements -->
                    <div class="mb-3">
                        <label for="Requirementsinput" class="form-label fw-bold" style="font-family: 'Poppins', sans-serif;">
                            Requirements <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" id="requirements" name="requirements" rows="10" placeholder="Enter Requirements" required></textarea>
                    </div>
                    <div class="row mb-3">
                    <div class="col-md-4"  style="width: 27%">
                        <label for="photo" class="form-label fw-bold" style="font-family: 'Poppins', sans-serif;">
                            Upload Photo <span class="text-danger">*</span>
                        </label>
                        <input type="file" class="form-control" id="job_photo" name="job_photo" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                    </div>
                        <!-- Keywords -->
                        <div class="col-md-3" style="width: 30%">
                            <label for="Keywords" class="form-label fw-bold" style="font-family: 'Poppins', sans-serif;">Keywords</label>
                            <input type="text" class="form-control" id="Keywords" name="keywords" placeholder="Enter Keywords">
                        </div>
                        <!-- Job Duration -->
                        <div class="col-md-3" style="width: 25%">
                            <label for="Duration" class="form-label fw-bold" style="font-family: 'Poppins', sans-serif;">Job Duration</label>
                            <input type="text" class="form-control" id="job_duration" name="job_duration" placeholder="Enter Duration">
                        </div>
                       
                    </div>
                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-custom">
                    <i class="fa-solid fa-arrow-up-from-bracket"></i> Post Job Details 
                    </button>
                </form>
            </div>
@endsection

@section('scripts')
<!-- TinyMCE API Script -->
<script src="https://cdn.tiny.cloud/1/v8mtbncvjp2xyv599m6wgnrpkyn221w76zclh4mob1vkwfpx/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
  tinymce.init({
    selector: '#job_description, #company_benefits, #requirements',  // Target the textarea
    plugins: 'lists link image code table',  // Enable desired plugins
    toolbar: 'undo redo | bold italic underline | alignleft aligncenter alignright | bullist numlist outdent indent | link image table code',
    menu: {
        file: { title: 'File', items: 'newdocument restoredraft | preview | print' },
        edit: { title: 'Edit', items: 'undo redo | cut copy paste | selectall' },
        view: { title: 'View', items: 'code | visualaid' },
        insert: { title: 'Insert', items: 'link image media | template hr' },
        format: { title: 'Format', items: 'bold italic underline strikethrough | formats blockformats align | forecolor backcolor' },
        tools: { title: 'Tools', items: 'spellchecker code wordcount' },
    },
    menubar: 'file edit view insert format tools',  // Show the full menubar
    branding: false,  // Hide the TinyMCE branding
    setup: function (editor) {
        editor.on('change', function () {
            editor.save();  // Ensure the editor content is synchronized with the original textarea
        });
    }
});
</script>
<!-- JavaScript for Handling Modal Data (optional) -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Flatpickr for start and end date inputs
        flatpickr("#start_date", {
            dateFormat: "d F, Y", // Display format: "29 November, 2024"
            enableTime: false,
            altInput: true,
            altFormat: "j F, Y",   // Alternate input format for readability
            locale: {
                firstDayOfWeek: 1  // Monday as the first day of the week
            }
        });

        flatpickr("#end_date", {
            dateFormat: "d F, Y",
            enableTime: false,
            altInput: true,
            altFormat: "j F, Y",
            locale: {
                firstDayOfWeek: 1
            }
        });
    });

    function saveDateRange() {
        const startDate = document.getElementById("start_date").value;
        const endDate = document.getElementById("end_date").value;

        // Process the selected dates (optional: display it somewhere on your page)
        console.log("Start Date:", startDate);
        console.log("End Date:", endDate);

        // Close the modal
        const modal = new bootstrap.Modal(document.getElementById('dateModal'));
        modal.hide();
    }
</script>
@endsection
