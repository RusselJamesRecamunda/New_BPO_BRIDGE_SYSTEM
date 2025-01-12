@extends('layouts.admin_pages')

@section('title', 'Departments')

@section('browser-icon')
    <link rel="icon" href="{{ asset('asset/img/browser-icons/bpo_icon.png') }}" type="image/x-icon">
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/shares.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/departments.css') }}">
@endsection

@section('departments-content')

    <!-- Top Bar -->
    @include('components.topbar')
    <h2 class="mb-4 fw-bold text-primary" style="margin-top: -20px;"><i class="fa-solid fa-building me-3"></i> All Departments</h2>
    <div class="department-container mb-4">
         <!-- Department Cards -->
         <div class="row">
            <!-- Department -->
            @foreach ($departments as $department => $employees)
                <div class="col-md-6 col-lg-6">
                    <div class="department-card">
                        <div class="department-header">
                            <h4>{{ $department }} Department</h4>
                            <a href="{{ route('department-info.index', ['department' => $department]) }}" class="text-decoration-none">View All</a>
                        </div>
                        <p>{{ count($employees) }} Members</p>
                        <div class="department-members">
                            <ul>
                                @foreach ($employees->take(5) as $employee) <!-- Limit to 5 employees -->
                                    <li>
                                        <div class="member-info">
                                            <img src="{{ asset('storage/' . $employee->emp_pic) }}" class="me-3" alt="Avatar">
                                            <div>
                                                <h5>{{ $employee->first_name }} {{ $employee->last_name }}</h5>
                                                <small>{{ $employee->designation }}</small>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection

@section('scripts')
   
@endsection
