@extends('layouts.admin_pages')

@section('title', 'Jobs')

@section('styles')
    <!-- Add additional styles specific to this view here -->
    <link rel="stylesheet" href="{{ asset('asset/css/shares.css') }}">
@endsection

@section('jobs-content')
        <!-- Top Bar -->
        @include('components.topbar')

        <div class="mb-4">
            <!-- Search and Button Row -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="custom-search-bar">
                        <input type="text" placeholder="Search">
                        <button type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                <button class="btn btn-primary" type="button" data-url="{{ route('admin.job-posting') }}" id="jobPostingButton""><i class="fa-solid fa-circle-plus me-2"></i>Post New Job</button>
            </div>
        </div>
          
        <!-- Job Cards Display -->
        <div class="row">
            <!-- Job 1 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <img src="{{ asset('asset/img/bpo_logo.png') }}" alt="Company Logo" style="width: 50px;">
                            <div>
                                <h5 class="card-title">Globela Inc.</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Project Manager</h6>
                            </div>
                        </div>
                        <p class="card-text">$1,200 - $1,800</p>
                        <p class="card-text">
                            It is a long established fact that a reader will be distracted by the readable content.
                        </p>
                        <p class="card-text">Opening Jobs (15/20)</p>
                        <div class="progress mb-3">
                            <div class="progress-bar bg-danger" style="width: 75%;"></div>
                        </div>
                        <a href="#" class="btn btn-primary">View Applications</a>
                        <p class="text-muted mt-2"><small><i class="fas fa-map-marker-alt"></i> Miami</small></p>
                    </div>
                </div>
            </div>

            <!-- Job 2 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <img src="path_to_logo" alt="Company Logo" style="width: 50px;">
                            <div>
                                <h5 class="card-title">Another Corp.</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Software Engineer</h6>
                            </div>
                        </div>
                        <p class="card-text">$3,500 - $4,500</p>
                        <p class="card-text">
                            Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                        </p>
                        <p class="card-text">Opening Jobs (10/20)</p>
                        <div class="progress mb-3">
                            <div class="progress-bar bg-success" style="width: 50%;"></div>
                        </div>
                        <a href="#" class="btn btn-primary">View Applications</a>
                        <p class="text-muted mt-2"><small><i class="fas fa-map-marker-alt"></i> New York</small></p>
                    </div>
                </div>
            </div>

            <!-- Job 3 -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <img src="path_to_logo" alt="Company Logo" style="width: 50px;">
                            <div>
                                <h5 class="card-title">Tech Inc.</h5>
                                <h6 class="card-subtitle mb-2 text-muted">Data Scientist</h6>
                            </div>
                        </div>
                        <p class="card-text">$2,800 - $3,200</p>
                        <p class="card-text">
                            The standard chunk of Lorem Ipsum used since the 1500s is reproduced below.
                        </p>
                        <p class="card-text">Opening Jobs (18/20)</p>
                        <div class="progress mb-3">
                            <div class="progress-bar bg-warning" style="width: 90%;"></div>
                        </div>
                        <a href="#" class="btn btn-primary">View Applications</a>
                        <p class="text-muted mt-2"><small><i class="fas fa-map-marker-alt"></i> San Francisco</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>
@endsection

@section('scripts')
<script>
      document.getElementById('jobPostingButton').addEventListener('click', function() {
        var url = this.getAttribute('data-url');
        window.location.href = url;
    });
</script>
@endsection
