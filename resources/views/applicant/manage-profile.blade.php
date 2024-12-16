@extends('layouts.applicant_pages') 

@section('title', 'Manage Profile')

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/manage-profile.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
@endsection

@section('manage-profile-content')
    <!-- Banner -->
    @guest
        <div class="catalog-banner d-flex flex-column justify-content-center align-items-center">
            <div class="profile-header d-flex align-items-center justify-content-center">
                <h1 class="mt-1 me-3">This account doesn’t exist yet</h1>
                <img src="{{ asset('asset/img/user.png') }}" alt="User Icon" class="user-icon" style="width: 80px; height: 80px;">
            </div>
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
            <div class="shape shape-4"></div>
        </div>
        <!-- Body Section -->
        <div class="container profile-body p-4">
            <p class="text-muted" style="max-width: 600px; margin: 0 auto;">
                Complete your Profile Information to unlock your BPO career potential! Whether you're taking your first step into the industry or bringing years of experience, a detailed profile helps match you with the perfect opportunities. Our HR Management team is actively searching for candidates like you, and a complete profile increases your visibility by 80%. Plus, you'll enjoy personalized job recommendations, faster application processes, and direct connections with top BPO employers across the Philippines. Join thousands of successful professionals who started their journey with a BPO Bridge profile. It takes just a few minutes to open a world of opportunities!
            </p>
            <div class="text-center mt-4">
                <a href="{{ route('register') }}"><button class="btn btn-primary create-profile-btn">Register</button></a>
            </div>
        </div>
    @endguest

    @auth
        <!-- Catalog Banner for logged-in users -->
        <div class="catalog-banner d-flex flex-column justify-content-center align-items-center">
            <h1 class="mt-1">Manage Profile</h1>
            <div class="d-flex justify-content-center mb-3">
                <a href="your-link-here" class="btn btn-outline-light me-3" style="outline: 1px solid #fff;">
                    <i class="fa-regular fa-pen-to-square me-2"></i>Edit
                </a>
                <a href="your-link-here" class="btn btn-outline-light" style="outline: 1px solid #fff;">
                    <i class="fa-regular fa-share-from-square me-2"></i>Share
                </a>
            </div>
            <div class="shape shape-1"></div>
            <div class="shape shape-2"></div>
            <div class="shape shape-3"></div>
            <div class="shape shape-4"></div>
        </div>

        <!-- Profile Section -->
        <div class="profile">
            <div class="row">
                <!-- Left Side: Profile Image -->
                <div class="col-md-4 text-center">
                    <img id="profileImage" src="https://via.placeholder.com/200" alt="Profile Picture" class="profile-img mb-2">

                    <!-- Upload Image Button -->
                    <div class="mt-2">
                        <label for="imageUpload" class="custom-btn">Upload Photo</label>
                        <input type="file" id="imageUpload" accept="image/*" style="display: none;">
                    </div>
                </div>

                <!-- Right Side: Profile Information Form -->
                <div class="col-md-8 form-section">
                    <form>
                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <label for="firstName" class="small text-uppercase">First Name</label>
                                <input type="text" class="form-control" id="firstName" value="Andrew" readonly>
                            </div>
                            <div class="form-group col-md-5">
                                <label for="lastName" class="small text-uppercase">Last Name</label>
                                <input type="text" class="form-control" id="lastName" value="Turing" readonly>
                            </div>
                        </div>

                        <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label for="address" class="small text-uppercase">Full Address</label>
                                    <input type="text" class="form-control" id="address" value="Sorsogon City" readonly>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="phone" class="small text-uppercase">Phone</label>
                                    <input type="text" class="form-control" id="phone" value="555-237-2384" readonly>
                                </div>
                                <div class="form-group col-md-10 mt-3">
                                    <label for="email" class="small text-uppercase">Email Address</label>
                                    <input type="email" class="form-control" id="email" value="andrew.turing@cryptographyinc.com" readonly>
                                </div>

                                <div class="profile-section col-12 mt-3 mb-4">
                                    <h3>Date of Birth</h3>
                                    <button class="btn" style="outline: 2px solid#0F5078; color: #0F5078; font-weight: 600;" onmouseover="this.style.backgroundColor='#0F5078'; this.style.color='white';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#0F5078';">Add Birthdate</button>
                                </div>
                                <div class="profile-section col-12 mb-4">
                                    <h3>Brief Summary</h3>
                                    <p id="summary-text" class="summary-text">Write your brief summary to introduce yourself</p>
                                    <button class="btn" style="outline: 2px solid#0F5078; color: #0F5078; font-weight: 600;" onmouseover="this.style.backgroundColor='#0F5078'; this.style.color='white';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#0F5078';">Add Brief Summary</button>
                                </div>
                                <div class="profile-section col-12 mb-4">
                                <h3>Skills</h3>
                                <div>
                                    <p>Show them your skill set</p>
                                    <div id="skills-list" class="skills-display"></div>
                                </div>
                                <button class="btn" style="outline: 2px solid#0F5078; color: #0F5078; font-weight: 600;" onmouseover="this.style.backgroundColor='#0F5078'; this.style.color='white';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#0F5078';">Add Skills</button>
                            </div>  
                        </div>

                            <h5 class="mt-4">External Links</h5>
                            <div class="d-flex flex-column">
                                <div class="d-flex align-items-center mb-2">
                                    <p class="mb-0 me-2"><i class="fa-brands fa-facebook me-2"></i>Facebook URL</p>
                                    <a href="" class="mb-0" style="color: #0F5078">https://www.facebook.com/russeljames.recamunda/</a>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <p class="mb-0 me-2"><i class="fa-brands fa-linkedin me-2"></i>LinkedIn URL</p>
                                    <a href="" class="mb-0" style="color: #0F5078">LinkedIn</a>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <p class="mb-0 me-2"><i class="fa-brands fa-github me-2"></i>Github URL</p>
                                    <a href="" class="mb-0" style="color: #0F5078">Github</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endauth
@endsection


@section('scripts')
<!-- Scripts -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('imageUpload').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('profileImage').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection