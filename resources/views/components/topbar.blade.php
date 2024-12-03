<div class="d-flex justify-content-between align-items-center mb-5" style="margin-top: 0;">
    <!-- Search Bar -->
    <div class="input-group" style="max-width: 450px;">
        <input type="text" class="form-control" placeholder="Search Here" aria-label="Search" aria-describedby="button-search" style="border-radius: 20px 0 0 20px; background-color: #d7d7d7; border: 1px solid #d7d7d7;">
        <button class="btn btn-outline-secondary" type="button" id="button-search" style="border-radius: 0 20px 20px 0; background-color: #d7d7d7; border: 1px solid #d7d7d7;">
            <i class="fas fa-search"></i>
        </button>
    </div>
      
    <!-- Notification Bell and Profile Dropdown -->
    <div class="d-flex align-items-center">
        <!-- Notification Bell -->
        <!-- <button class="btn btn-outline-primary me-3" type="button">
            <i class="fas fa-bell"></i>
        </button> -->
        <!-- Profile Dropdown -->
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle fw-bold" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="{{ asset('asset/img/browser-icons/bpo_icon.png') }}" alt="Profile Picture" width="40" height="40" class="rounded-circle me-2">
                <span>{{ Auth::user()->first_name }}</span> <!-- Display first_name here -->
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown" style="font-family: 'Poppins', sans-serif;">
                <li>
                    <a class="dropdown-item d-flex align-items-center text-custom-color" href="#">
                        <i class="fa-solid fa-user me-2"></i>Profile
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf <!-- Include CSRF token for security -->
                    </form>
                    <a class="dropdown-item d-flex align-items-center text-custom-color" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa-solid fa-right-from-bracket me-2"></i>Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
