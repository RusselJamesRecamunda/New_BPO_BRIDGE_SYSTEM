<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recruitment Form</title>
    <link rel="icon" href="{{ asset('asset/img/browser-icon/bpo_icon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('asset/css/submission.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar with Logo -->
    <nav class="navbar fixed-top w-100">
        <div class="container-fluid">
            <a class="navbar-brand">
                <img src="{{ asset('asset/img/bpo_logo.png') }}" alt="BPO Logo" class="logo">
            </a>
        </div>
    </nav>
    @if (session('error'))
    <script>
        window.errorMessage = "{{ session('error') }}";
    </script>
@endif

@if (session('success'))
    <script>
        window.successMessage = "{{ session('success') }}";
    </script>
@endif

    <!-- Form Container -->
    <div class="container mt-5 pt-5">
        <h2 class="text-center">Recruitment Submission:</h2>
        <form id="applicationForm" method="POST" action="{{ route('recruitment-submission.store') }}" enctype="multipart/form-data">
    @csrf
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="firstName" class="form-label">First Name:</label>
            <input type="text" class="form-control" id="first_name" name="first_name" style="margin-bottom:20px;" required>
        </div>
        <div class="col-md-6">
            <label for="lastName" class="form-label">Last Name:</label>
            <input type="text" class="form-control" id="last_name" name="last_name" required>
        </div>
        <div class="col-md-6">
            <label for="email" class="form-label">E-mail:</label>
            <input type="text" class="form-control" id="email" name="email" required>
        </div>
        <div class="col-md-6">
            <label for="pnumber" class="form-label">Phone Number:</label>
            <input type="text" class="form-control" id="phone" name="phone">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">2x2 Photo:</label>
            <div class="file-upload" onclick="document.getElementById('2x2_pic').click()">
                <i class="fa-solid fa-cloud-arrow-up upload-icon"></i>
                <p>Upload a File<br><small>Drag and drop files here</small></p>
                <input type="file" id="2x2_pic" name="2x2_pic" accept=".pdf, .jpg, .png" required style="display: none;">
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label">Birth Certificate:</label>
            <div class="file-upload" onclick="document.getElementById('birth_certificate').click()">
                <i class="fa-solid fa-cloud-arrow-up upload-icon"></i>
                <p>Upload a File<br><small>Drag and drop files here</small></p>
                <input type="file" id="birth_certificate" name="birth_certificate" accept=".pdf, .jpg, .png" required style="display: none;">
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">BIR:</label>
            <div class="file-upload" onclick="document.getElementById('bir_form').click()">
                <i class="fa-solid fa-cloud-arrow-up upload-icon"></i>
                <p>Upload a File<br><small>Drag and drop files here</small></p>
                <input type="file" id="bir_form" name="bir_form" accept=".pdf" required style="display: none;">
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label">Health Certificate:</label>
            <div class="file-upload" onclick="document.getElementById('health_cert').click()">
                <i class="fa-solid fa-cloud-arrow-up upload-icon"></i>
                <p>Upload a File<br><small>Drag and drop files here</small></p>
                <input type="file" id="health_cert" name="health_cert" accept=".pdf, .jpg, .png" required style="display: none;">
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">TIN Number:</label>
            <div class="file-upload" onclick="document.getElementById('tin_number').click()">
                <i class="fa-solid fa-cloud-arrow-up upload-icon"></i>
                <p>Upload a File<br><small>Drag and drop files here</small></p>
                <input type="file" id="tin_number" name="tin_number" accept=".pdf, .jpg, .png" required style="display: none;">
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label">PhilHealth ID Number:</label>
            <div class="file-upload" onclick="document.getElementById('philhealth_id').click()">
                <i class="fa-solid fa-cloud-arrow-up upload-icon"></i>
                <p>Upload a File<br><small>Drag and drop files here</small></p>
                <input type="file" id="philhealth_id" name="philhealth_id" accept=".pdf, .jpg, .png" required style="display: none;">
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">SSS:</label>
            <div class="file-upload" onclick="document.getElementById('sss').click()">
                <i class="fa-solid fa-cloud-arrow-up upload-icon"></i>
                <p>Upload a File<br><small>Drag and drop files here</small></p>
                <input type="file" id="sss" name="sss" accept=".pdf" required style="display: none;">
            </div>
        </div>
        <div class="col-md-6">
            <label class="form-label">Pag-ibig Number:</label>
            <div class="file-upload" onclick="document.getElementById('pagibig_membership_id').click()">
                <i class="fa-solid fa-cloud-arrow-up upload-icon"></i>
                <p>Upload a File<br><small>Drag and drop files here</small></p>
                <input type="file" id="pagibig_membership_id" name="pagibig_membership_id" accept=".pdf, .jpg, .png" required style="display: none;">
            </div>
        </div>
    </div>
    <div class="button-group">
        <button type="submit" class="btn btn-primary">Submit Documents</button>
    </div>
</form>

    </div>

    <script src="{{ asset('asset/js/submission.js') }}"></script>
    <!-- SweetAlert Integration -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.successMessage = "{{ session('success') }}";
</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        if (typeof window.errorMessage !== "undefined" && window.errorMessage) {
            Swal.fire({
                icon: "error",
                title: "Submission Failed",
                text: window.errorMessage,
                confirmButtonText: "Retry",
            });
        }

        if (typeof window.successMessage !== "undefined" && window.successMessage) {
            Swal.fire({
                icon: "success",
                title: "Success",
                text: window.successMessage,
                confirmButtonText: "OK",
            });
        }
    });
</script>
</html>