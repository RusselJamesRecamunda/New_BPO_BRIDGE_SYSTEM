@extends('layouts.admin_pages')

@section('title', 'Departments')

@section('browser-icon')
    <link rel="icon" href="{{ asset('asset/img/browser-icons/department.png') }}" type="image/x-icon">
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/shares.css') }}">
    <style> 
          /* Container with background color */
        .department-container {
            background-color: #D9D9D9;
            padding: 20px;
            border-radius: 8px;
            height: 188vh;
        }

        /* Button styles */
        .btn-primary {
            background-color: #0F5078;
            border: none;
            padding: 10px 10px;
            font-weight: bold;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0C3E5A;
        }

        .btn-sm{
            background-color: #0F5078;
            border: none;
            padding: 5px 10px;
            font-weight: bold;
            color: white;  
        }

        .department-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            padding: 15px;
            margin-bottom: 20px;
        }

        .department-card h5 {
            font-weight: bold;
        }

        .department-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .department-members ul {
            list-style-type: none;
            padding: 0;
        }

        .department-members ul li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
        }

        .department-members ul li img {
            border-radius: 50%;
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        .department-members ul li .member-info {
            display: flex;
            align-items: center;
        }
    </style>
@endsection

@section('departments-content')

    <!-- Top Bar -->
    @include('components.topbar')
    <h2 class="mb-4 fw-bold text-primary" style="margin-top: -20px;"><i class="fa-solid fa-building me-3"></i> All Departments</h2>
    <div class="department-container mb-4">
        <!-- Search bar and Add New Candidate button -->
        <div class="mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="custom-search-bar">
                    <input type="text" placeholder="Search">
                    <button type="submit">
                        <i class="fas fa-search"></i>
                     </button>
                </div>
            </div>
        </div>
         <!-- Department Cards -->
         <div class="row">
            <!-- Design Department -->
            <div class="col-md-6 col-lg-6">
                <div class="department-card">
                    <div class="department-header">
                        <h5>Design Department</h5>
                        <a href="{{ route('department-info.index') }}">View All</a>
                    </div>
                    <p>20 Members</p>
                    <div class="department-members">
                        <ul>
                            <li>
                                <div class="member-info">
                                    <img src="{{ asset('asset/img/bpo_logo.png') }}" alt="Avatar">
                                    <div>Dianne Russell<br><small>Lead UI/UX Designer</small></div>
                                </div>
                                <i class="fas fa-chevron-right"></i>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Sales Department -->
            <div class="col-md-6 col-lg-6">
                <div class="department-card">
                    <div class="department-header">
                        <h5>Sales Department</h5>
                        <a href="{{ route('department-info.index') }}">View All</a>
                    </div>
                    <p>14 Members</p>
                    <div class="department-members">
                        <ul>
                            <li>
                                <div class="member-info">
                                    <img src="{{ asset('asset/img/bpo_logo.png') }}" alt="Avatar">
                                    <div>Darrell Steward<br><small>Sr. Sales Manager</small></div>
                                </div>
                                <i class="fas fa-chevron-right"></i>
                            </li>
                            <!-- Add more members similarly -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
   
@endsection
