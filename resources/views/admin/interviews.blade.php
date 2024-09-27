@extends('layouts.admin_pages')

@section('title', 'Schedule Interview')

@section('styles')
    <!-- Add additional styles specific to this view here -->
    <link rel="stylesheet" href="{{ asset('asset/css/shares.css') }}">
    <link rel="stylesheet" href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css'>
@endsection

@section('interviews-content')
    <!-- Top Bar -->
    @include('components.topbar')

    <!-- Calendar Container -->
    <div id='calendar'></div>
@endsection

@section('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,listWeek'
            },
            events: '/path-to-your-events-data', // Replace with your endpoint
            eventClick: function(info) {
                alert('Event: ' + info.event.title);
                // Add custom logic here
            },
            editable: true, // Allows users to drag and drop events
            selectable: true, // Allows users to select dates
            select: function(info) {
                alert('Selected time: ' + info.startStr + ' to ' + info.endStr);
                // Add logic for creating new events or handling selection
            }
        });
        calendar.render();
    });
    </script>
@endsection
