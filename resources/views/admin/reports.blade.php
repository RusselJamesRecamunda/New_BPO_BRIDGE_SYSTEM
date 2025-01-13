@extends('layouts.admin_pages')

@section('title', 'General Reports')

@section('browser-icon')
    <link rel="icon" href="{{ asset('asset/img/browser-icons/bpo_icon.png') }}" type="image/x-icon">
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/shares.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/job_application.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>
 .custom-select-container {
    position: relative;
    width: 205px;
}

.custom-dropdown {
    padding: 2px 12px 5px 50px; /* Adjusted padding to make more space for the icon */
    background-color: #0f5078;
    color: white;
    width: 100%;
    border: 1px solid #0f5078;
    border-radius: 4px;
}

.calendar-icon {
    position: absolute;
    top: 50%;
    left: 20px; /* Moved icon 20px to the left */
    transform: translateY(-50%);
    color: white;
    pointer-events: none;
}

.custom-dropdown option {
    padding-left: 50px; /* Increased padding to accommodate the icon */
    font-size: 15px;
    font-weight: 500;
}

.custom-dropdown option:first-child {
    padding-left: 20px; /* Adjust first option to align with the icon */
}


</style>
@endsection

@section('reports-content')
<meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Top Bar -->
    @include('components.topbar')

    <!-- Search bar and Add New Candidate button -->
    <div class="applicant-container mb-4">

    <div class="custom-tabs">
        <div class="custom-tab active" onclick="showTab('new-hire-info')">
            <i class="fa-solid fa-circle-info me-2"></i>Official Reports
        </div>
        <div class="custom-tab" onclick="showTab('submitted-documents')">
            <i class="fas fa-file-alt me-2"></i>Submitted Documents
        </div>
        <div class="ms-auto d-flex align-items-center">
            <div class="export-buttons d-flex align-items-center">
                <button class="export-button" onclick="exportStyledTableToExcel('newHireTable')">
                    <i class="fa-solid fa-file-excel me-2"></i>Export New Hire Report
                </button>
            </div>
            <!-- Weekly Button -->
            <button class="btn btn-primary ms-2" id="weeklyBtn" style="padding: 6px 12px; display: flex; align-items: center;">
                <i class="fa-solid fa-calendar-week me-2"></i>Weekly
            </button>

            <!-- Monthly Dropdown -->
            <div class="d-flex align-items-center">
                <div class="custom-select-container">
                    <select id="monthlyDropdown" class="form-select ms-2 custom-dropdown" style="width: 200px;">
                        <option value="">Select Month</option>
                        <!-- Dynamically populate months -->
                        @foreach(range(1, 12) as $month)
                            <option value="{{ $month }}">{{ \Carbon\Carbon::create()->month($month)->format('F') }}</option>
                        @endforeach
                    </select>
                    <i class="fa-solid fa-calendar-days calendar-icon"></i>
                </div>
            </div>
        </div>
    </div>




        <!-- New Hire Info Content -->
        <div id="new-hire-info" style="display: block;">
            <!-- New Hire Reports Table -->
            <div id="report-section" class="table-responsive">
                <table id="newHireTable" class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Employee Name</th>
                            <th>Employee ID</th>
                            <th>Email Address</th>
                            <th>Type of Work</th>
                            <th>Company Department</th>
                            <th>Department Manager</th>
                            <th>Hire Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($newHire as $hire)
                        <tr>
                            <td>{{$hire->emp_first_name}} {{$hire->emp_last_name}}</td>
                            <td>{{$hire->official_emp_id}}</td>
                            <td>{{$hire->email}}</td>
                            <td>{{$hire->work_type}}</td>
                            <td>{{$hire->project_department}}</td>
                            <td>{{$hire->dept_manager}}</td>
                            <td>{{ \Carbon\Carbon::parse($hire->hire_date)->format('F j, Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Submitted Documents Content -->
        <div id="submitted-documents" style="display: none;">
            <!-- Submitted Documents Table -->
            <div class="table-responsive">
                <table id="submittedDocsTable" class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Employee Name</th>
                            <th>Job Title</th>
                            <th>2x2 Photo</th>
                            <th>Birth Certificate</th>
                            <th>Tin Number</th>
                            <th>PhilHealth</th>
                            <th>Pag-Ibig</th>
                            <th>SSS</th>
                            <th>BIR Form</th>
                            <th>Health Certificate</th>
                            <th>Download Files as ZIP</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($newDocument as $document)
                            <tr>
                                <td>{{ $document->candidate_name }}</td>
                                <td>{{ $document->applied_job }}</td>

                                <!-- 2x2 Photo -->
                                <td>
                                    @if ($document['2x2_pic'])
                                        <a href="{{ asset('storage/' . str_replace('public/', '', $document['2x2_pic'])) }}" target="_blank" download>
                                            <i class="fa-solid fa-file-arrow-down text-danger fs-3"></i>
                                            <p class="text-dark fw-light mt-2" style="font-size: 10px;">Download 2x2 Photo</p>
                                        </a>
                                    @else
                                        <span>No 2x2 Photo</span>
                                    @endif
                                </td>

                                <!-- Birth Certificate -->
                                <td>
                                    @if ($document['birth_certificate'])
                                        <a href="{{ asset('storage/' . str_replace('public/', '', $document['birth_certificate'])) }}" target="_blank" download>
                                            <i class="fa-solid fa-file-arrow-down text-danger fs-3"></i>
                                            <p class="text-dark fw-light mt-2" style="font-size: 10px;">Download Birth Certificate</p>
                                        </a>
                                    @else
                                        <span>No Birth Certificate</span>
                                    @endif
                                </td>

                                <!-- Tin Number -->
                                <td>
                                    @if ($document['tin_number'])
                                        <a href="{{ asset('storage/' . str_replace('public/', '', $document['tin_number'])) }}" target="_blank" download>
                                            <i class="fa-solid fa-file-arrow-down text-danger fs-3"></i>
                                            <p class="text-dark fw-light mt-2" style="font-size: 10px;">Download Tin Number</p>
                                        </a>
                                    @else
                                        <span>No Tin Number</span>
                                    @endif
                                </td>

                                <!-- PhilHealth -->
                                <td>
                                    @if ($document['philhealth_id'])
                                        <a href="{{ asset('storage/' . str_replace('public/', '', $document['philhealth_id'])) }}" target="_blank" download>
                                            <i class="fa-solid fa-file-arrow-down text-danger fs-3"></i>
                                            <p class="text-dark fw-light mt-2" style="font-size: 10px;">Download PhilHealth</p>
                                        </a>
                                    @else
                                        <span>No PhilHealth</span>
                                    @endif
                                </td>

                                <!-- Pag-Ibig -->
                                <td>
                                    @if ($document['pagibig_membership_id'])
                                        <a href="{{ asset('storage/' . str_replace('public/', '', $document['pagibig_membership_id'])) }}" target="_blank" download>
                                            <i class="fa-solid fa-file-arrow-down text-danger fs-3"></i>
                                            <p class="text-dark fw-light mt-2" style="font-size: 10px;">Download Pag-Ibig</p>
                                        </a>
                                    @else
                                        <span>No Pag-Ibig</span>
                                    @endif
                                </td>

                                <!-- SSS -->
                                <td>
                                    @if ($document['sss'])
                                        <a href="{{ asset('storage/' . str_replace('public/', '', $document['sss'])) }}" target="_blank" download>
                                            <i class="fa-solid fa-file-arrow-down text-danger fs-3"></i>
                                            <p class="text-dark fw-light mt-2" style="font-size: 10px;">Download SSS</p>
                                        </a>
                                    @else
                                        <span>No SSS</span>
                                    @endif
                                </td>

                                <!-- BIR Form -->
                                <td>
                                    @if ($document['bir_form'])
                                        <a href="{{ asset('storage/' . str_replace('public/', '', $document['bir_form'])) }}" target="_blank" download>
                                            <i class="fa-solid fa-file-arrow-down text-danger fs-3"></i>
                                            <p class="text-dark fw-light mt-2" style="font-size: 10px;">Download BIR Form</p>
                                        </a>
                                    @else
                                        <span>No BIR Form</span>
                                    @endif
                                </td>

                                <!-- Health Certificate -->
                                <td>
                                    @if ($document['health_cert'])
                                        <a href="{{ asset('storage/' . str_replace('public/', '', $document['health_cert'])) }}" target="_blank" download>
                                            <i class="fa-solid fa-file-arrow-down text-danger fs-3"></i>
                                            <p class="text-dark fw-light mt-2" style="font-size: 10px;">Download Health Certificate</p>
                                        </a>
                                    @else
                                        <span>No Health Certificate</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-primary download-zip-btn" data-doc-id="{{ $document->doc_id }}">
                                        <i class="fa-solid fa-file-zipper"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.3.0/exceljs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1/moment.min.js"></script>
    <script src="{{ asset('asset/js/reports.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Attach event listener to all "Download All Files" buttons
        document.querySelectorAll('.download-zip-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Get the doc_id from the button's data-doc-id attribute
                const docId = this.getAttribute('data-doc-id');
                
                // If docId is missing, show an error
                if (!docId) {
                    console.error('Document ID not found.');
                    return;
                }

                // Prepare an array to hold all file URLs and names
                const filesToDownload = [];

                // Get the candidate name from the current row
                const row = this.closest('tr');
                const candidateName = row.querySelector('td').innerText.trim(); // First cell contains the candidate name

                // Iterate through all the links in the current row and collect file URLs and names
                row.querySelectorAll('td a').forEach(link => {
                    if (link.href) {
                        const fileName = link.querySelector('p').innerText || 'Unnamed File';
                        filesToDownload.push({
                            url: link.href,
                            name: fileName
                        });
                    }
                });

                // If no files are available to download, show a SweetAlert error
                if (filesToDownload.length === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'No Files Available',
                        text: 'There are no files to download for this entry.',
                    });
                    return;
                }

                // Show SweetAlert confirmation before proceeding with the download
                Swal.fire({
                    title: 'Download All Files',
                    text: 'Are you sure you want to download all the available files as a ZIP?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Download!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Create a new JSZip instance
                        const zip = new JSZip();

                        // Loop through each file and add it to the zip
                        let fileCount = 0;
                        filesToDownload.forEach(file => {
                            fetch(file.url)
                                .then(response => response.blob())
                                .then(blob => {
                                    zip.file(file.name, blob); // Add file to the zip

                                    fileCount++;
                                    // If all files are added, generate the zip file and trigger the download
                                    if (fileCount === filesToDownload.length) {
                                        zip.generateAsync({ type: "blob" })
                                            .then(function(content) {
                                                // Use the candidate name as the zip file name
                                                const zipFileName = `${candidateName}.zip`;

                                                // Trigger the download
                                                const link = document.createElement('a');
                                                const url = window.URL.createObjectURL(content);
                                                link.href = url;
                                                link.download = zipFileName; // Set the file name dynamically
                                                link.click(); // Trigger the download
                                            });
                                    }
                                })
                                .catch(error => {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Download Failed',
                                        text: 'There was an error while preparing your download.',
                                    });
                                });
                        });
                    }
                });
            });
        });
    });
</script>


@endsection
