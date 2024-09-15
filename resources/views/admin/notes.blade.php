@extends('layouts.admin_pages')

@section('title', 'Interview Notes')

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/shares.css') }}">
    <style>
    /* Container with background color */
    .applicant-container {
        background-color: #D9D9D9;
        padding: 20px;
        border-radius: 8px;
        height: 193vh;
    }
    /* Button styles */
    .btn-primary {
        background-color: #0F5078;
        border: none;
        padding: 10px 20px;
        font-weight: bold;
        color: white;
    }

    .btn-primary:hover {
        background-color: #0C3E5A;
    }
    /* Table styles */
    table th, table td {
        text-align: center;
        vertical-align: middle;
    }
    </style>
@endsection

@section('result-content')

    <!-- Top Bar -->
    @include('components.topbar')

    <div class="applicant-container mb-4">
        <!-- Search bar and Add New Candidate button -->
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="custom-search-bar">
                        <input type="text" placeholder="Search">
                        <button type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                <button class="btn btn-primary"><i class="fa-solid fa-circle-plus me-2"></i>Add New Candidate</button>
            </div>
        </div>

        <!-- Applicant Result Table -->
        <div id="interview-notes-section" class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Interview ID</th>
                        <th>Candidate Name</th>
                        <th>Interviewer</th>
                        <th>Interview Mode</th>
                        <th>Resume/CV</th>
                        <th>Cover Letter</th>
                        <th>Applied Job</th>
                        <th>Total Applicants</th>
                        <th>Interview Notes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Carlo Dela Peña</td>
                        <td>Software Engineer</td>
                        <td><i class="bi bi-file-earmark"></i></td>
                        <td>2024-08-22</td>
                        <td>7</td>
                        <td>0921-123-4567</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('scripts')
   
@endsection
