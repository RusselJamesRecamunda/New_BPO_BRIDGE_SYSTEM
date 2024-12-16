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
                                    <img src="{{ asset('asset/img/profile-image.jpg') }}" alt="Profile" class="rounded-circle" width="40">
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


    <!-- Footer --> 
    <footer class="footer text-white py-5 mt-5">
        <div class="container mb-3">
            <div class="row">
            <!-- About Section -->
            <section class="col-md-3 col-12 d-flex flex-column mb-4" aria-labelledby="footer-about"  style="margin-top: -4%;">
                <div class="d-flex align-items-center mb-2">
                    <!-- Image with Bootstrap classes for margin adjustment -->
                    <img src="{{ asset('asset/img/bpo_logo.png') }}" alt="BPO Bridge Logo" class="logo-footer" style="width: 160px; height: auto; margin-top: -15%; margin-left: 20%;">
                    <h5 id="footer-about" class="mb-0">About</h5>
                </div>
                <p class="small text-center justify-content-center align-items-center" style="margin-top: -15%;">
                    BPO Bridge is a comprehensive job recruitment platform dedicated to bridging the gap between talented professionals and leading BPO companies. Our mission is to simplify the recruitment process, making it easier and more efficient for both job seekers and employers.
                </p>
            </section>

                <!-- Quick Links -->
                <nav class="col-md-3 pr-md-5" aria-labelledby="footer-quick-links" style="padding-left: 10%;">
                    <h5 id="footer-quick-links" class="mb-4">Quick Links</h5>
                    <ul class="list-unstyled small">
                        <li><a href="#" class="text-white"><i class="fa-solid fa-arrow-left-long me-2"></i>About</a></li>
                        <li><a href="#" class="text-white"><i class="fa-solid fa-arrow-left-long me-2"></i>FAQs</a></li>
                        <li><a href="#" class="text-white"><i class="fa-solid fa-arrow-left-long me-2"></i>Contact</a></li>
                        <li><a href="#" class="text-white"><i class="fa-solid fa-arrow-left-long me-2"></i>Listing</a></li>
                        <li><a href="#" class="text-white"><i class="fa-solid fa-arrow-left-long me-2"></i>Membership</a></li>
                        <li><a href="#" class="text-white"><i class="fa-solid fa-arrow-left-long me-2"></i>Profile</a></li>
                    </ul>
                </nav>

                <!-- Contact Info Section -->
                <section class="col-md-3 pl-md-4" aria-labelledby="footer-contact">
                    <h5 id="footer-contact" class="mb-4">Contact Info</h5>
                    <address class="small">
                        <p class="mb-2">Sutherland Global Services, Legazpi City Port, 2nd Floor BPO Bldg. 4500 Albay</p>
                        <p class="mb-2"><i class="fa fa-phone mr-2"></i>09388541155</p>
                        <p class="mb-2"><i class="fa fa-envelope mr-2"></i>bpobridge2024@gmail.com</p>
                    </address>
                    <div class="d-flex mt-3" aria-label="Social Media Links">
                        <a href="https://www.facebook.com/LegazpiSiteCouncil" class="text-white me-3"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.linkedin.com/company/sutherland-global/" class="text-white me-3"><i class="fab fa-linkedin"></i></a>
                        <a href="https://www.instagram.com/sutherlandlifeapac/" class="text-white"><i class="fab fa-instagram"></i></a>
                    </div>
                </section>

                <!-- Subscribe Section -->
                <section class="col-md-3" aria-labelledby="footer-subscribe">
                    <h5 id="footer-subscribe" class="mb-4">Subscribe</h5>
                    <p class="small">Sign Up To Our Newsletter And Get The Latest Offers.</p>
                    <form aria-label="Subscribe Form">
                        <div class="mb-3">
                            <input type="email" class="form-control" placeholder="Your Email Address" aria-label="Email Address">
                        </div>
                        <div class="">
                            <button class="btn btn-primary text-uppercase w-50" type="button" style="background-color: #0F5078; border: none; color: #fff;">Subscribe</button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
        <!-- Bottom Section -->
        <div class=" border-top pt-4" style="font-size: 12px;">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-6 text-left">
                        <p class="mb-0">BPO-BRIDGE 2024 <i class="fa fa-copyright ms-1"></i>All rights reserved.</p>
                    </div>
                    <div class="col-md-6 col-sm-6 text-right">
                        <nav aria-label="Footer Policies">
                            <ul class="d-flex justify-content-end list-unstyled mb-0">
                                <li class="mx-2"><a href="#" class="text-white">Terms of Use</a></li>
                                <li class="mx-2"><a href="#" class="text-white">Privacy Policy</a></li>
                                <li class="mx-2"><a href="#" class="text-white">Cookie Policy</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('asset/js/home.js') }}"></script>
    @yield('jobapplication-scripts')
    @stack('save-script')
</body>
</html> 
