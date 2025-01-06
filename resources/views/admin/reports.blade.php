@extends('layouts.admin_pages')

@section('title', 'General Reports')

@section('browser-icon')
    <link rel="icon" href="{{ asset('asset/img/browser-icons/bpo_icon.png') }}" type="image/x-icon">
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/shares.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/job_application.css') }}">
@endsection

@section('reports-content')

    <!-- Top Bar -->
    @include('components.topbar')

    <!-- Search bar and Add New Candidate button -->
    <div class="applicant-container mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="custom-search-bar">
                <input type="text" placeholder="Search">
                    <button type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>

            <div class="export-buttons">
                <button class="export-button"><i class="fa-solid fa-file-excel me-2"></i>Excel</button>
            </div>
        </div>

        <!-- Tabs -->
        <div class="custom-tabs">
            <div class="custom-tab active" onclick="showTab('new-hire-info')"> 
                <i class="fa-solid fa-circle-info me-2"></i>Official Reports
            </div>
            <div class="custom-tab" onclick="showTab('submitted-documents')">
                <i class="fas fa-file-alt me-2"></i>Submitted Documents
            </div>
        </div>

        <!-- New Hire Info Content -->
        <div id="new-hire-info" style="display: block;">
            <!-- New Hire Reports Table -->
            <div id="report-section" class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Employee Name</th>
                            <th>Employee ID</th>
                            <th>Email Address</th>
                            <th>Job Title</th>
                            <th>Type of Work</th>
                            <th>Company Department</th>
                            <th>Department Manager</th>
                            <th>Hire Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Carlo Dela Peña</td>
                            <td>Software Engineer</td>
                            <td>2024-08-22</td>
                            <td>carlo@example.com</td>
                            <td>0921-123-4567</td>
                            <td>Full-Time</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Submitted Documents Content -->
        <div id="submitted-documents" style="display: none;">
            <!-- Submitted Documents Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
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
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        function showTab(tabName) {
            // Hide all tabs
            document.getElementById('new-hire-info').style.display = 'none';
            document.getElementById('submitted-documents').style.display = 'none';

            // Show the selected tab
            document.getElementById(tabName).style.display = 'block';

            // Update active tab
            var tabs = document.querySelectorAll('.custom-tab');
            tabs.forEach(tab => {
                tab.classList.remove('active');
            });
            event.target.closest('.custom-tab').classList.add('active');
        }
    </script>
@endsection
