<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('asset/img/browser-icons/bpo_icon.png') }}">
    <title>@yield('title', 'BPO-BRIDGE')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('asset/css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/home-footer.css') }}">
    @yield('styles')
</head>
<body>
 
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <img src="{{ asset('asset/img/bpo_logo.png') }}" alt="BPO Logo" style="width: 100px; height: 100px; margin: -20px 30px -20px;">
        <div class="container">
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav" style="margin-left: -40px;">
                    <li class="nav-item me-3">
                        <a class="nav-link {{ Route::is('home') ? 'active' : '' }}" href="{{ route('home') }}">Available Jobs</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link {{ Route::is('manage-profile.index') ? 'active' : '' }}" href="{{ route('manage-profile.index') }}">Profile</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link {{ Route::is('about-us.index') ? 'active' : '' }}" href="{{ route('about-us.index') }}">About</a>
                    </li>
                    <li class="nav-item me-3">
                        <a class="nav-link {{ Route::is('contact-us.index') ? 'active' : '' }}" href="{{ route('contact-us.index') }}">Contact</a>
                    </li>
                </ul>
                @if (Route::has('login'))
                    <ul class="navbar-nav ms-auto">
                        @auth
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <!-- <img src="{{ asset('asset/img/profile-image.jpg') }}" alt="Profile" class="rounded-circle" width="40"> -->
                                    <img id="profileImage" class="image rounded-circle profile-img mb-2" 
                                    src="{{ Auth::user()->user_photo && file_exists(public_path('storage/user-photos/' . Auth::user()->user_photo)) 
                                        ? asset('storage/user-photos/' . Auth::user()->user_photo) 
                                        : asset('asset/img/applicant/default-user.jpg') }}" 
                                    alt="Profile Image" 
                                    style="width: 40px; height: 40px; cursor: pointer;">
                                    <span class="ms-2">{{ auth()->user()->first_name }}</span>
                                    <span class="dropdown-icon">▼</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                <li>
                                    <a class="dropdown-item" href="#">Profile</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('applied-saved.index', ['tab' => 'applied']) }}">Job applications</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">Settings</a>
                                </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Sign out
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li> 
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link">Log in</a>
                            </li>
                            <li class="nav-item">
                                <span class="nav-link">|</span>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="nav-link">Register</a>
                                </li>
                            @endif
                        @endauth
                    </ul>
                @endif
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('manage-profile-content')
        @yield('about-us-content')
        @yield('contact-us-content')
        @yield('job-info-content')
        @yield('applied-saved-content')
    </main>

    <!-- Footer Content -->
    @include('components.home-footer')


    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('asset/js/home.js') }}"></script>
    @yield('jobapplication-scripts')
    @stack('save-script')
    @yield('profile-script')
</body>
</html> 
