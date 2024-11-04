<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- browser-icon section -->
    @yield('browser-icon')
    <title>@yield('title', 'Dashboard')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome (for icons) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    @yield('styles') <!-- For additional CSS files -->
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
         <div style="height: 100vh;">
         @include('components.sidebar')
         </div>

         
        <!-- Main Content Area -->
        <div id="content" class="w-100 p-4 flex-grow-1">
            
            <!-- Content Admin Pages -->
            @yield(section: 'applicant-tracker-content')
            @yield('result-content')
            @yield('notes-content')
            @yield('employees-content')
            @yield('add-employee-content')
            @yield('departments-content')
            @yield('department-info-content')
            @yield('jobs-content')
            @yield('overview-content')
            @yield('job-posting-content')
            @yield('applications-content')    
            @yield('users-content')
            @yield('interviews-content') 
            @yield('reports-content') 
        </div>
    </div>
        <!-- Include Footer -->
        @include('components.admin-footer')


    <!-- jQuery and Bootstrap JS -->
    <script src="{{ asset('asset/js/sidebar.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @yield('scripts') <!-- For additional JavaScript files -->
</body>
</html>
