@extends('layouts.admin_pages')

@section('title', 'Job Applications')

@section('browser-icon')
    <link rel="icon" href="{{ asset('asset/img/browser-icons/application.png') }}" type="image/x-icon">
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/shares.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/job_application.css') }}">
@endsection

@section('applications-content')

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
                <button class="export-button"><i class="fa-solid fa-file-pdf me-2"></i>PDF</button>
                <button class="export-button"><i class="fa-solid fa-print me-2"></i>Print</button>
            </div>
        </div>

        <!-- Tabs -->
        <div class="custom-tabs">
            <div class="custom-tab active" onclick="showTab('applicant-info')"> 
                <i class="fas fa-user me-2"></i>Applicant Information
            </div>
            <div class="custom-tab" onclick="showTab('documents')">
                <i class="fas fa-file-alt me-2"></i>Documents
            </div>
        </div>

        <!-- Applicant Info Content -->
        <div id="applicant-info" style="display: block;">
            <!-- Applicant Result Table -->
            <div id="applicant-result-section" class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Applicant Name</th>
                            <th>Applied For</th>
                            <th>Applied Date</th>
                            <th>Email Address</th>
                            <th>Mobile Number</th>
                            <th>Job Type</th>
                            <th>Application Status</th>
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
                            <td>
                                <select class="status-select badge-in-process">
                                    <option value="Scheduled" class="badge-scheduled">Scheduled</option>
                                    <option value="In Process" class="badge-in-process" selected>In Process</option>
                                    <option value="Rejected" class="badge-rejected">Rejected</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Documents Content -->
        <div id="documents" style="display: none;">
            <!-- Documents Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Applicant Name</th>
                            <th>Applied For</th>
                            <th>Resume/Curriculum Vitae (CV)</th>
                            <th>Cover Letter</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Leslie Watson</td>
                            <td>UI/UX Designer</td>
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
            document.getElementById('applicant-info').style.display = 'none';
            document.getElementById('documents').style.display = 'none';

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
