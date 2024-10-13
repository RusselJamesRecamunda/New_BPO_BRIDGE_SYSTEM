@extends('layouts.admin_pages')

@section('title', 'Schedule Interview')

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
    </style>
@endsection

@section('interviews-content')
    <!-- Top Bar -->
    @include('components.topbar')

    <!-- Calendar Container -->
    <div id="calendar-container" class="container mt-4">
        <div id="calendar" style="width: 100%; height: 100%;"></div>
    </div>

    <!-- Backdrop Overlay -->
    <div class="modal-backdrop" id="modalBackdrop"></div>

    <!-- Modal for scheduling interview -->
    <div class="modal" id="interviewModal" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add/Edit Interview Schedule</h5>
                    <button type="button" class="close" id="closeModalBtn">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="interviewForm">
                        <div class="form-group">
                            <label for="candidate_name">Candidate Name *</label>
                            <input type="text" id="candidate_name" name="candidate_name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="applied_job">Applied Job *</label>
                            <input type="text" id="applied_job" name="applied_job" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="interview_mode">Interview Mode *</label>
                            <select id="interview_mode" name="interview_mode" class="form-control" required>
                                <option value="Online">Online</option>
                                <option value="In-Person">In-Person</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone *</label>
                            <input type="text" id="phone" name="phone" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="interview_date">Interview Date *</label>
                            <input type="date" id="interview_date" name="interview_date" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="interview_time">Interview Time *</label>
                            <input type="time" id="interview_time" name="interview_time" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Interview</button>
                        <button type="button" class="btn btn-secondary" id="closeModalBtn">Cancel</button>
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
    
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // Set up CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,dayGridWeek,dayGridDay,listWeek'
            },
            events: function (fetchInfo, successCallback, failureCallback) {
                $.ajax({
                    url: "{{ route('interviews.index') }}", // Fetch from index route
                    method: 'GET',
                    success: function (data) {
                        console.log(data); // Check data structure

                        // Transform data to match FullCalendar event structure
                        var events = data.map(function (interview) {
                            return {
                                id: interview.id,
                                title: interview.title,
                                start: interview.start, // 'YYYY-MM-DDTHH:MM:SS' format
                                extendedProps: {
                                    applied_job: interview.applied_job,
                                    interview_mode: interview.interview_mode,
                                    email: interview.email,
                                    phone: interview.phone
                                }
                            };
                        });

                        successCallback(events); // Render events on the calendar
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText); // Log error for debugging
                        failureCallback(); // Handle fetch failure
                    }
                });
            },
            editable: true,
            selectable: true,

            select: function (info) {
                openModal(info.startStr);
            },

            eventClick: function (info) {
                $('#interviewModal').show();
                $('.modal-backdrop').show();

                // Fill form with event data
                $('#candidate_name').val(info.event.title);
                $('#applied_job').val(info.event.extendedProps.applied_job);
                $('#interview_mode').val(info.event.extendedProps.interview_mode);
                $('#email').val(info.event.extendedProps.email);
                $('#phone').val(info.event.extendedProps.phone);
                $('#interview_date').val(info.event.start.toISOString().split('T')[0]);
                $('#interview_time').val(info.event.start.toTimeString().split(' ')[0].substring(0, 5));

                // Update form submission for event update
                $('#interviewForm').off('submit').on('submit', function (e) {
                    e.preventDefault();
                    var formData = $(this).serialize();
                    $.ajax({
                        url: `/interviews/${info.event.id}`, // Use event ID for update
                        type: 'PUT',
                        data: formData,
                        success: function () {
                            alert("Interview updated successfully.");
                            calendar.refetchEvents(); // Reload events
                            closeModal();
                        },
                        error: function (xhr) {
                            console.error(xhr.responseText); // Log error
                            alert("Failed to update interview.");
                        }
                    });
                });
            }
        });

        calendar.render();

        // Close modal handler
        $('#closeModalBtn').on('click', function () {
            closeModal();
        });

        // Open modal for new interview
        function openModal(startDate) {
            $('#interviewModal').show();
            $('.modal-backdrop').show();
            $('#interviewForm')[0].reset(); // Reset form
            $('#interview_date').val(startDate.split('T')[0]);
            $('#interview_time').val('09:00'); // Default time

            $('#interviewForm').off('submit').on('submit', function (e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: "{{ route('interviews.store') }}",
                    type: 'POST',
                    data: formData,
                    success: function () {
                        alert("Interview scheduled successfully.");
                        calendar.refetchEvents(); // Reload events
                        closeModal();
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText); // Log error
                        alert("Failed to schedule interview.");
                    }
                });
            });
        }

        // Close modal function
        function closeModal() {
            $('#interviewModal').hide();
            $('.modal-backdrop').hide();
        }
    });
</script>


@endsection
