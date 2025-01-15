@extends('layouts.admin_pages')

@section('title', 'Applicant Tracker')

@section('browser-icon')
    <link rel="icon" href="{{ asset('asset/img/browser-icons/bpo_icon.png') }}" type="image/x-icon">
@endsection

@section('styles') 
    <!-- Add additional styles specific to this view here -->
    <link rel="stylesheet" href="{{ asset('asset/css/shares.css') }}">
    <style>
        /* Ensure the chart adjusts correctly on resizing */
        #applicantChart {
            width: 100% !important;
            height: 600px !important; /* Adjust height to your preference */
        }

        /* Center the Upcoming Interviews and Applicants to Review sections */
        .chart-container {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            gap: 30px;
        }

        .upcoming-interviews, .applicants-to-review {
            width: 48%;
        }

        /* Ensure the layout is responsive */
        @media (max-width: 991px) {
            .chart-container {
                flex-direction: column;
                align-items: center;
            }

            .upcoming-interviews, .applicants-to-review {
                width: 100%;
            }
        }
    </style>
@endsection

@section('applicant-tracker-content')
    <!-- Top Bar -->
    @include('components.topbar')

    <!-- Tracker Cards -->
    <div class="mb-4">
        <h2 class="mb-4 fw-bold text-primary" style="margin-top: -10px;">
            <i class="fa-solid fa-chart-bar fa-1x me-3"></i>Applicant Tracker
        </h2>

        <!-- Additional Content -->
        <div class="row">
            <div class="col-lg-3 col-md-4">
                <!-- Sidebar content here (if needed) -->
            </div>

            <!-- Charts and Other Data -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <!-- Insert Chart Here -->
                            <canvas id="applicantChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- This div holds the data attributes and does not have the same ID as the canvas -->
            <div id="applicantChartData" data-weeks="{{ json_encode($weeks) }}" data-chart-data="{{ json_encode($chartData) }}"></div>


            <!-- Chart and sections side by side -->
            <div class="chart-container">
                <!-- Upcoming Interviews -->
                <div class="card upcoming-interviews mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Upcoming Interviews</h5>
                        <ul class="list-group">
                            <li class="list-group-item">John Doe <span class="text-muted">09:20 - 09:45</span></li>
                            <li class="list-group-item">Jane Smith <span class="text-muted">10:20 - 10:45</span></li>
                            <li class="list-group-item">John Doe <span class="text-muted">09:20 - 09:45</span></li>
                            <li class="list-group-item">Jane Smith <span class="text-muted">10:20 - 10:45</span></li>
                            <li class="list-group-item">John Doe <span class="text-muted">09:20 - 09:45</span></li>
                            <li class="list-group-item">Jane Smith <span class="text-muted">10:20 - 10:45</span></li>
                            <li class="list-group-item">John Doe <span class="text-muted">09:20 - 09:45</span></li>
                            <li class="list-group-item">Jane Smith <span class="text-muted">10:20 - 10:45</span></li>
                        </ul>
                        <div class="text-center mt-3">
                            <a href="#" class="btn btn-primary">See Schedules</a>
                        </div>
                    </div>
                </div>

                <!-- Applications to Review -->
                <div class="card applicants-to-review mb-4">
    <div class="card-body">
        <h5 class="card-title">Applications to Review</h5>
        <table class="table table-borderless">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Total Applied</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $category => $data)
                <tr>
                    <td>{{ $category }}</td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar bg-primary" 
                                data-percentage="{{ $data['percentage'] }}" 
                                role="progressbar" 
                                aria-valuemin="0" 
                                aria-valuemax="100">
                                {{ $data['percentage'] }}%
                            </div>
                        </div>
                        <center><span>{{ $data['total'] }} pending applications</span></center>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Add chart.js script for the chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('asset/js/applicant-tracker.js') }}"></script>
@endsection
