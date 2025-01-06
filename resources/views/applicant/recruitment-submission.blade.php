<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recruitment Form</title>
    <link rel="icon" href="{{ asset('asset/img/browser-icon/bpo_icon.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('asset/css/submission.css') }}">
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

    <!-- Form Container -->
    <div class="container mt-5 pt-5">
        <h2 class="text-center">Recruitment Submission:</h2>
        <form id="applicationForm">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="firstName" class="form-label">First Name:</label>
                    <input type="text" class="form-control" id="firstName" style="margin-bottom:20px;" required>
                </div>
                <div class="col-md-6">
                    <label for="lastName" class="form-label">Last Title:</label>
                    <input type="text" class="form-control" id="lastName" required>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">E-mail:</label>
                    <input type="text" class="form-control" id="email" required>
                </div>
                <div class="col-md-6">
                    <label for="pnumber" class="form-label">Phone Number:</label>
                    <input type="text" class="form-control" id="pnumber" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">2x2 Photo:</label>
                    <div class="file-upload" onclick="document.getElementById('photo').click()">
                        <img src="{{ asset('asset/img/insert.png') }}" alt="Upload Icon" class="upload-icon">
                        <p>Upload a File<br><small>Drag and drop files here</small></p>
                        <input type="file" id="photo" accept=".pdf, .jpg, .png" required style="display: none;">
                    </div> 
                </div>
                <div class="col-md-6">
                    <label class="form-label">Birth Certificate:</label>
                    <div class="file-upload" onclick="document.getElementById('birthCertificate').click()">
                        <img src="{{ asset('asset/img/insert.png') }}" alt="Upload Icon" class="upload-icon">
                        <p>Upload a File<br><small>Drag and drop files here</small></p>
                        <input type="file" id="birthCertificate" accept=".pdf, .jpg, .png" required style="display: none;">
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">BIR:</label>
                    <div class="file-upload" onclick="document.getElementById('bir').click()">
                        <img src="{{ asset('asset/img/insert.png') }}" alt="Upload Icon" class="upload-icon">
                        <p>Upload a File<br><small>Drag and drop files here</small></p>
                        <input type="file" id="bir" accept=".pdf" required style="display: none;">
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Health Certificate:</label>
                    <div class="file-upload" onclick="document.getElementById('healthCertificate').click()">
                        <img src="{{ asset('asset/img/insert.png') }}" alt="Upload Icon" class="upload-icon">
                        <p>Upload a File<br><small>Drag and drop files here</small></p>
                        <input type="file" id="healthCertificate" accept=".pdf, .jpg, .png" required style="display: none;">
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">TIN Number:</label>
                    <div class="file-upload" onclick="document.getElementById('tinNumber').click()">
                        <img src="{{ asset('asset/img/insert.png') }}" alt="Upload Icon" class="upload-icon">
                        <p>Upload a File<br><small>Drag and drop files here</small></p>
                        <input type="file" id="tinNumber" accept=".pdf, .jpg, .png" required style="display: none;">
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">PhilHealth ID Number:</label>
                    <div class="file-upload" onclick="document.getElementById('philHealthId').click()">
                        <img src="{{ asset('asset/img/insert.png') }}" alt="Upload Icon" class="upload-icon">
                        <p>Upload a File<br><small>Drag and drop files here</small></p>
                        <input type="file" id="philHealthId" accept=".pdf, .jpg, .png" required style="display: none;">
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">SSS:</label>
                    <div class="file-upload" onclick="document.getElementById('sss').click()">
                        <img src="{{ asset('asset/img/insert.png') }}" alt="Upload Icon" class="upload-icon">
                        <p>Upload a File<br><small>Drag and drop files here</small></p>
                        <input type="file" id="sss" accept=".pdf" required style="display: none;">
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Pag-ibig Number:</label>
                    <div class="file-upload" onclick="document.getElementById('pagIbigNumber').click()">
                        <img src="{{ asset('asset/img/insert.png') }}" alt="Upload Icon" class="upload-icon">
                        <p>Upload a File<br><small>Drag and drop files here</small></p>
                        <input type="file" id="pagIbigNumber" accept=".pdf, .jpg, .png" required style="display: none;">
                    </div>
                </div>
            </div>        
            <div class="button-group">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
            <!-- Confirmation Modal -->
            <div id="confirmationModal" class="modal">
                <div class="modal-content">
                    <p>Thank you for filling up, please wait for our email for further information.</p>
                    <button id="modalOkButton" class="btn btn-primary">OK</button>
                </div>
            </div>
        </form>
    </div>

    <script src="{{ asset('asset/js/submission.js') }}"></script>

</body>

</html>