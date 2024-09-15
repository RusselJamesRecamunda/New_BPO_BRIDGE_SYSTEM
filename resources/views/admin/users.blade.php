@extends('layouts.admin_pages')

@section('title', 'Users')

@section('styles')
    <!-- Add additional styles specific to this view here -->
    <link rel="stylesheet" href="{{ asset('asset/css/shares.css') }}">
@endsection

@section('users-content')

        <!-- Top Bar -->
        @include('components.topbar')

        
        <div class="mb-4">
          
        </div>
          
        <!-- Additional Content -->
        <div class="row">
           
            <div class="col-lg-3 col-md-4">
               
            </div>

          

           
        </div>
       
@endsection

@section('scripts')
    <!-- Add additional scripts specific to this view here -->
    <script src="{{ asset('asset/js/sidebar.js') }}"></script>
@endsection
