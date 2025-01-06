<!-- resources/views/components/_sidebar.blade.php -->
<nav id="sidebar">
    <div class="sidebar-header">
    <img src="{{ asset('asset/img/bpo_logo.png') }}" alt="Logo">
        <button type="button" id="sidebarCollapse">
            <i class="fas fa-bars" style="font-size: 25px;"></i>
        </button>
    </div>
    <ul class="list-unstyled components">
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
        </li>
        <li class="nav-item dropdown"> 
            <!-- Applicant Tracker as a link that toggles the dropdown -->
            <a href="#" class="nav-item" id="applicantTrackerDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-chart-line"></i> <span>Applicant Tracker</span>
            </a>

            <ul class="dropdown-menu" aria-labelledby="applicantTrackerDropdown">
                <li>
                    <!-- Clicking this will go to the 'applicant.tracker' route -->
                    <button class="dropdown-item fs-6" type="button" data-url="{{ route('applicant-tracker.index') }}">
                        <i class="fa-solid fa-chart-line me-3"></i>Home Tracker
                    </button>
                </li>
                <li>
                    <!-- Clicking this will go to the 'applicant.results' route -->
                    <button class="dropdown-item fs-6" type="button" data-url="{{ route('applicant-results.index') }}">
                        <i class="fa-solid fa-check-to-slot me-3"></i>Applicant Results
                    </button>
                </li>
                <!-- <li>
                    
                    <button class="dropdown-item fs-6" type="button" data-url="{{ route('notes.index') }}">
                        <i class="fa-solid fa-comment me-3"></i>Interview Notes
                    </button>
                </li> -->
            </ul>
        </li>
  
        <li class="nav-item dropdown">
            <!-- Employees as a link that toggles the dropdown -->
            <a href="#" class="nav-link" id="employeesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-users"></i> <span>Employees</span>
            </a>

            <ul class="dropdown-menu" aria-labelledby="employeesDropdown">
                <li>
                    <!-- Clicking this will go to the 'employees' route -->
                    <button class="dropdown-item fs-6" type="button" data-url="{{ route('employees.index') }}">
                    <i class="fa-solid fa-user-tie me-4"></i>All Employees
                    </button>
                </li>
                <li>
                    <!-- Clicking this will go to the 'departments' route -->
                    <button class="dropdown-item fs-6" type="button" data-url="{{ route('departments.index') }}">
                        <i class="fa-solid fa-building me-4"></i>All Departments
                    </button>
                </li>
            </ul>
        </li>

        <li class="nav-item dropdown">
            <!-- Jobs as a link that toggles the dropdown -->
            <a href="#" class="nav-link" id="jobBoardDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-briefcase"></i> <span>Job Board Pages</span>
            </a>

            <ul class="dropdown-menu" aria-labelledby="jobBoardDropdown">
                <li>
                    <!-- Clicking this will go to the 'jobs' route -->
                    <button class="dropdown-item fs-6" type="button" data-url="{{ route('jobs.index') }}">
                        <i class="fa-solid fa-briefcase me-4"></i>Manage Jobs
                    </button>
                </li>
                <li>
                    <!-- Clicking this will go to the 'applications' route -->
                    <button class="dropdown-item fs-6" type="button" data-url="{{ route('applications.index') }}">
                        <i class="fa-solid fa-file-lines me-4"></i>Applications
                    </button>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="{{ route('users.index') }}"><i class="fas fa-user-cog"></i> <span>User Accounts</span></a>
        </li>
        <li class="nav-item">
            <a href="{{ route('interviews.index') }}"><i class="fa-solid fa-calendar-check"></i> <span>Interviews</span></a>
        </li>
        <li class="nav-item">
            <a href="{{ route('reports.index') }}"><i class="fas fa-folder-open"></i> <span>General Reports</span></a>
        </li>
    </ul>
    <footer class="sidebar-footer">
        BPO Bridge Dashboard<br>
        &copy; 2024 All Rights Reserved<br>
        by BU
    </footer>
</nav>
