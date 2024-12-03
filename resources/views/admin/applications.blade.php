@extends('layouts.admin_pages')

@section('title', 'Job Applications')

@section('browser-icon')
    <link rel="icon" href="{{ asset('asset/img/browser-icons/bpo_icon.png') }}" type="image/x-icon">
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/shares.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/job_application.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
      <!-- SweetAlert2 CDN -->
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('applications-content')

    <!-- Top Bar -->
    @include('components.topbar')
    <!-- Success Message (SweetAlert will handle it now) -->
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    <!-- Search bar and Export button -->
    <div class="applicant-container mb-4">
        <!-- Tabs -->
        <div class="custom-tabs">
            <div class="custom-tab active" data-tab="applicant-info"> 
                <i class="fa-solid fa-users-gear me-2"></i>Applicant Information
            </div>
            <div class="custom-tab" data-tab="documents">
                <i class="fas fa-file-alt me-2"></i>Documents
            </div>

        </div>

        <!-- Applicant Info Content -->
        <div id="applicant-info" style="display: block;">
            <div id="applicant-result-section" class="table-responsive">
                <table id="applicant-table" class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Application ID</th>
                            <th>Applicant Name</th>
                            <th>Applied For</th>
                            <th>Applied On</th>
                            <th>Salary</th>
                            <th>Address</th>
                            <th>Job Type</th>
                            <th>Application Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $application)
                        <tr>
                            <td>{{ $application->application_id }}</td>
                            <td>{{ $application->applicant_name }}</td>
                            <td>{{ $application->fullTimeJobPosting->job_title ?? $application->freelanceJobPosting->job_title }}</td>
                            <td>{{ \Carbon\Carbon::parse($application->app_date)->format('F j, Y') }}</td>
                            <td>₱ {{ $application->fullTimeJobPosting->basic_pay ?? 'N/A' }}</td>
                            <td>{{ $application->applicant_location }}</td>
                            <td>{{ $application->job_type }}</td>
                            <td>
                                <form action="{{ route('applications.updateStatus', $application->application_id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select class="status-select badge-{{ strtolower(str_replace(' ', '-', $application->application_status)) }}" name="status" onchange="this.form.submit()">
                                        <option value="Scheduled" @if($application->application_status == 'Scheduled') selected @endif class="badge-scheduled">Scheduled</option>
                                        <option value="In Process" @if($application->application_status == 'In Process') selected @endif class="badge-in-process">In Process</option>
                                        <option value="Rejected" @if($application->application_status == 'Rejected') selected @endif class="badge-rejected">Rejected</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

       <!-- Documents Content -->
        <div id="documents" style="display: none;">
            <div class="table-responsive">
                <table id="documents-table" class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Applicant Name</th>
                            <th>Applied For</th>
                            <th>Resume/CV</th>
                            <th>Cover Letter</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($applications as $application)
                        <tr>
                            <td>{{ $application->applicant_name }}</td>
                            <td>{{ $application->fullTimeJobPosting->job_title ?? $application->freelanceJobPosting->job_title }}</td>
                            <td>
                                @if ($application->resume_cv)
                                    <a href="{{ asset('storage/' . str_replace('public/', '', $application->resume_cv)) }}" target="_blank" download>
                                        <i class="fa-solid fa-file-arrow-down text-danger fs-3">
                                            <p class="text-dark fw-light mt-2" style="font-size: 10px;">Download Resume/CV</p>
                                        </i>
                                    </a>
                                @else
                                    <span>No Resume</span>
                                @endif
                            </td>
                            <td>
                                @if ($application->cover_letter)
                                    <a href="{{ asset('storage/' . str_replace('public/', '', $application->cover_letter)) }}" target="_blank" download>
                                        <i class="fa-solid fa-file-arrow-down text-danger fs-3">
                                            <p class="text-dark fw-light mt-2" style="font-size: 10px;">Download Cover Letter</p>
                                        </i>
                                    </a>
                                @else
                                    <span>No Cover Letter</span>
                                @endif
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
    <script src="{{ asset('asset/js/admin-applications.js') }}"></script>
    <!-- Add SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    var exportUrl = "{{ route('applications.exportApplications') }}";
    </script>
    <script>
    // Listen for form submission
    $('form').on('submit', function (e) {
        e.preventDefault(); // Prevent the form from submitting the usual way

        var form = $(this);
        var status = form.find('select[name="status"]').val();
        var url = form.attr('action');  // Get the form action URL

        // Send an AJAX request to update the status
        $.ajax({
            url: url,
            method: 'POST',
            data: form.serialize(),
            success: function(response) {
                // Show a success alert
                alert(response.message);
                // Optionally, you can also update the status select box with the new status
                form.find('select[name="status"]').val(status);
            },
            error: function() {
                alert('Failed to update the application status');
            }
        });
    });
</script>

@endsection
