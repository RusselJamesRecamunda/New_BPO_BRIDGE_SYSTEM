<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('asset/img/browser-icons/bpo_icon.png') }}">
    <title>@yield('title', 'BPO-BRIDGE')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @yield('styles')
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <img src="{{ asset('asset/img/bpo_logo.png') }}" alt="BPO Logo" style="width: 100px; height: 100px; margin: -20px 30px -20px;">
        <div class="container">
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav" style="margin-left: -40px;">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Available Jobs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about-us.index') }}">About BPO Bridge</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                </ul>
                @if (Route::has('login'))
                    <ul class="navbar-nav ms-auto">
                        @auth
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ asset('asset/img/profile-image.jpg') }}" alt="Profile" class="rounded-circle" width="40">
                                    <span class="ms-2">{{ auth()->user()->first_name }}</span>
                                    <span class="dropdown-icon">▼</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                                    <li><a class="dropdown-item" href="#">Profile</a></li>
                                    <li><a class="dropdown-item" href="#">Job applications</a></li>
                                    <li><a class="dropdown-item" href="settings.html">Settings</a></li>
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
                                    <a href="{{ route('register') }}" class="nav-link">Signup</a>
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
        @yield('profile-content')
        @yield('about-us-content')
        @yield('job-info-content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container text-center">
            <div class="row">
                <div class="col-md-4 text-start">
                    <p>Company Information</p>
                    <p>BPO</p>
                    <p>Address</p>
                    <p>Contact No.</p>
                </div>
                <div class="col-md-4 text-center"> 
                    <img src="{{ asset('asset/img/bpo_logo.png') }}" alt="BPO Bridge Logo" class="logo-footer">
                </div>
                <div class="col-md-4 text-end">
                    <!-- Optional Content -->
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('asset/js/home.js') }}"></script>
    @yield('scripts')
</body>
</html>
