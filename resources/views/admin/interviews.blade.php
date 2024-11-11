@extends('layouts.admin_pages')

@section('title', 'Schedule Interview')

@section('browser-icon')
    <link rel="icon" href="{{ asset('asset/img/browser-icons/bpo_icon.png') }}" type="image/x-icon">
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/shares.css') }}">
    <link rel="stylesheet" href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
    <style>
        /* Styles for blur effect and modal */
        #calendar-container {
            position: relative;
            z-index: 1;
            width: 100%;
            height: 100%;
        }

        /* Blur effect applies only to the backdrop */
        body.blurred #calendar-container {
            filter: blur(5px);
            pointer-events: none; /* Disable interactions with the blurred background */
        }

        /* Modal Styles */
        #interviewModal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 1050;
            background-color: #fff;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            border-radius: 8px;
            width: 670px;
            max-width: 100%;
            padding: 20px;
        }

        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent overlay */
            z-index: 1040;
            display: none;
        }
        .modal-content{
            margin-top: -6%;
        }

        .color-palette {
        display: flex;
        justify-content: start;
        margin-bottom: 20px;
}

.color-swatch {
    width: 30px;
    height: 30px;
    margin-right: 10px;
    border: 1px solid #ccc;
    cursor: pointer;
}

.color-swatch:hover {
    border: 2px solid #000;
}

.color-swatch.active {
    border: 3px solid #000;
}
    </style>
@endsection

@section('interviews-content')
    <!-- Top Bar -->
    @include('components.topbar')

    <h1 class="text-primary fw-bold mb-3"><i class="fa-solid fa-calendar-day me-3"></i>Schedule Interview For Candidate</h1>
    <!-- Calendar Wrapper Container -->
    <div id="calendar-container" class="container mt-4">
        <div id="calendar" style="width: 100%; height: 100%; margin-bottom: 100px"></div>
    </div>

    <!-- Backdrop Overlay -->
    <div class="modal-backdrop" id="modalBackdrop"></div>

    <!-- Modal for scheduling interview -->
    <div class="modal" id="interviewModal" style="display: none;">
        <div class="modal-dialog modal-lg"> <!-- Added modal-lg for a larger modal size -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add/Edit Interview Schedule</h5>
                    <button type="button" class="close" id="closeModalBtn">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="interviewForm">

                        <!-- First Row: Candidate Name & Applied Job -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="candidate_name">Candidate Name *</label>
                                    <input type="text" id="candidate_name" name="candidate_name" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="applied_job">Applied Job *</label>
                                    <input type="text" id="applied_job" name="applied_job" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <!-- Second Row: Interview Mode  -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="interview_mode">Interview Mode *</label>
                                    <select id="interview_mode" name="interview_mode" class="form-control" required>
                                        <option value="" disabled selected>Select Interview Mode</option>
                                        <option value="Zoom">Zoom</option>
                                        <option value="In-Person">In-Person</option>
                                        <option value="Phone">Phone</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="zoom_link">Upload Meeting Link</label>
                                    <input type="zoom_link" id="zoom_link" name="zoom_link" class="form-control">
                                </div>
                            </div>
                        </div>
        
                        <!-- Third Row: Email & Phone -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email *</label>
                                    <input type="email" id="email" name="email" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone">Phone *</label>
                                    <input type="text" id="phone" name="phone" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <!-- Fourth Row: Interview Time & Date -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="interview_time">Interview Time *</label>
                                    <input type="time" id="interview_time" name="interview_time" class="form-control" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="interview_date">Interview Date *</label>
                                    <input type="date" id="interview_date" name="interview_date" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Save Interview</button>
                            <button type="button" id="deleteInterviewBtn" class="btn btn-danger">Delete Interview</button>
                            <button type="button" class="btn btn-secondary" id="closeModalBtn">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('asset/js/interviews.js') }}"></script>
@endsection
