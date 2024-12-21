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
                <!-- Edit Button -->
                <a href="#" class="btn btn-outline-light me-3" data-bs-toggle="modal" data-bs-target="#editProfileModal" style="outline: 1px solid #fff;">
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

        <!-- Edit Personal Details Modal -->
        <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editProfileModalLabel">Edit personal details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('manage-profile.updateOrCreate') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="modal-body">
                            <!-- First Name and Last Name -->
                            <div class="row g-3 mb-3">
                                <div class="col-12 col-md-6">
                                    <label for="first_name" class="form-label">First name</label>
                                    <input type="text" name="first_name" id="first_name" class="form-control" placeholder="Russel James" value="{{ old('first_name', Auth::user()->first_name ?? '') }}" required>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="last_name" class="form-label">Last name</label>
                                    <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Recamunda" value="{{ old('last_name', Auth::user()->last_name ?? '') }}" required>
                                </div>
                            </div>

                            <!-- Home Location -->
                            <div class="mb-3">
                                <label for="address" class="form-label">Home location</label>
                                <input type="text" name="address" id="address" class="form-control" value="{{ old('address', Auth::user()->address ?? '') }}">
                            </div>

                            <!-- Phone Number -->
                            <div class="mb-3">
                                <label for="phone_number" class="form-label">
                                    Phone number <small class="text-muted">(recommended)</small>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">+63</span>
                                    <input type="text" name="phone_number" id="phone_number" 
                                        class="form-control" 
                                        value="{{ old('phone_number', ltrim(Auth::user()->phone_number ?? '', '+63')) }}" 
                                        maxlength="10" 
                                        pattern="\d{10}" 
                                        title="Enter a valid 10-digit phone number">
                                </div>
                            </div>

                            <!-- Email Address with Edit Link -->
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-3">
                                <div class="w-100">
                                    <label for="email" class="form-label">Email address</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', Auth::user()->email ?? '') }}" readonly>
                                </div>
                                <div class="mt-2 mt-md-0 ms-md-2">
                                    <a href="#" class="text-decoration-none" style="white-space: nowrap; font-size: 0.9rem;">Edit in Settings</a>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Buttons -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

            <!-- Profile Section -->
            <div class="profile">
                <div class="row">
                   <!-- Left Side: Profile Image -->
                    <div class="col-md-4 text-center">
                        <!-- Display profile image or placeholder if not set -->
                        <img id="profileImage" class="image rounded-circle profile-img mb-2" 
                                    src="{{ Auth::user()->user_photo && file_exists(public_path('storage/user-photos/' . Auth::user()->user_photo)) 
                                        ? asset('storage/user-photos/' . Auth::user()->user_photo) 
                                        : asset('asset/img/applicant/default-user.jpg') }}" 
                                    alt="Profile Image" 
                                    style="width: 250px; height: 250px; padding: 10px; margin: 0px; cursor: pointer;" 
                                    onclick="document.getElementById('imageUpload').click();">
                        <p class="text-primary fw-bold"><i class="fa-solid fa-arrow-up-right-from-square me-2 fs-5"></i>Click photo to update</p>
                        <!-- Hidden file input for image upload -->
                        <input type="file" id="imageUpload" name="user_photo" accept="image/*" style="display: none;" onchange="handleFileSelect(event)">
                    </div>

                    <!-- Right Side: Profile Information Form -->
                    <div class="col-md-8 form-section">
                        <form>
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label for="firstName" class="small text-uppercase">First Name</label>
                                    <input type="text" class="form-control" id="firstName" value="{{ $user->first_name ?? '' }}" readonly>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="lastName" class="small text-uppercase">Last Name</label>
                                    <input type="text" class="form-control" id="lastName" value="{{ $user->last_name ?? '' }}" readonly>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <label for="address" class="small text-uppercase">Home Address</label>
                                    <input type="text" class="form-control" id="address" value="{{ $user->address ?? '' }}" readonly>
                                </div>
                                <div class="form-group col-md-5">
                                    <label for="phone" class="small text-uppercase">Phone</label>
                                    <input type="text" class="form-control" id="phone" value="{{ $user->phone_number ?? '' }}" readonly>
                                </div>
                                <div class="form-group col-md-10 mt-3">
                                    <label for="email" class="small text-uppercase">Email Address</label>
                                    <input type="email" class="form-control" id="email" value="{{ $user->email ?? '' }}" readonly>
                                </div>
                            </div>

                            <div class="profile-section col-12 mt-3 mb-4">
                                <h3>Date of Birth</h3>
                                <button type="button" class="btn date-of-birth-btn" 
                                    style="outline: 2px solid #0F5078; color: #0F5078; font-weight: 600;"
                                    onmouseover="this.style.backgroundColor='#0F5078'; this.style.color='white';"
                                    onmouseout="this.style.backgroundColor='transparent'; this.style.color='#0F5078';">
                                    {{ $user->date_of_birth ? 'Update Birthdate' : 'Add Birthdate' }}
                                </button>
                            </div>

                            <div class="profile-section col-12 mb-4">
                                <h3>Brief Summary</h3>
                                <p id="summary-text" class="summary-text">
                                    {{ $user->summary ?? 'Write your brief summary to introduce yourself' }}
                                </p>
                                <button type="button" class="btn summary-btn" 
                                    style="outline: 2px solid #0F5078; color: #0F5078; font-weight: 600;"
                                    onmouseover="this.style.backgroundColor='#0F5078'; this.style.color='white';"
                                    onmouseout="this.style.backgroundColor='transparent'; this.style.color='#0F5078';">
                                    {{ $user->summary ? 'Update Summary' : 'Add Brief Summary' }}
                                </button>
                            </div>

                            <div class="profile-section col-12 mb-4">
                                <h3>Skills</h3>
                                <div>
                                    <p>{{ $user->skills ? 'Your Skills' : 'Show them your skill set' }}</p>
                                    <div id="skills-list" class="skills-display">{{ $user->skills ?? '' }}</div>
                                </div>
                                <div id="suggested-skills" class="mt-2"></div>

                                <button type="button" class="btn skills-btn" 
                                    style="outline: 2px solid #0F5078; color: #0F5078; font-weight: 600;"
                                    onmouseover="this.style.backgroundColor='#0F5078'; this.style.color='white';"
                                    onmouseout="this.style.backgroundColor='transparent'; this.style.color='#0F5078';">
                                    Add Skills
                                </button>
                            </div>

                            <h5 class="mt-4">External Links</h5>
                            <div class="d-flex flex-column">
                                <div class="d-flex align-items-center mb-2">
                                    <p class="mb-0 me-2"><i class="fa-brands fa-facebook me-2"></i></p>
                                    <a href="" class="mb-0" style="color: #0F5078">https://www.facebook.com/russeljames.recamunda/</a>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <p class="mb-0 me-2"><i class="fa-brands fa-linkedin me-2"></i></p>
                                    <a href="" class="mb-0" style="color: #0F5078">LinkedIn</a>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <p class="mb-0 me-2"><i class="fa-brands fa-github me-2"></i></p>
                                    <a href="" class="mb-0" style="color: #0F5078">Github</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    @endauth
@endsection


@section('profile-script')
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <!-- Pass the CSRF token and route to JavaScript Manage Profile -->
    <!-- <script>
        var profileUpdateRoute = "{{ route('manage-profile.update', Auth::id()) }}";
        var csrfToken = "{{ csrf_token() }}";
    </script> -->
    <script>
        const profileUpdateRoute = "{{ route('manage-profile.update', ['manage_profile' => Auth::id()]) }}";
        const csrfToken = "{{ csrf_token() }}";
    </script>

    <script src="{{ asset('asset/js/manage-profile.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Prevent page reloads
            const preventReload = (event) => {
                event.preventDefault();
            };

            // Attach event listeners to buttons
            document.querySelector('.date-of-birth-btn').addEventListener('click', (e) => {
                preventReload(e); // Ensure no page reload
                Swal.fire({
                    title: 'Add or Update Birthdate',
                    html: `
                        <div>
                            <label for="birthdate-input" class="form-label">Enter your birthdate:</label>
                            <input type="date" id="birthdate-input" class="form-control">
                        </div>
                    `,
                    confirmButtonText: 'Close',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                    },
                    buttonsStyling: false,
                });
            });

            document.querySelector('.summary-btn').addEventListener('click', (e) => {
                preventReload(e);
                Swal.fire({
                    title: 'Edit Personal Summary',
                    html: `
                        <div class="text-center">
                            <label for="summary-input" class="form-label text-left w-100">Your Summary</label>
                            <textarea id="summary-input" class="form-control" rows="4" placeholder="Highlight your personal experiences, goals, and strengths."></textarea>
                        </div>

                    `,
                    confirmButtonText: 'Close',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                    },
                    buttonsStyling: false,
                });
            });

            document.querySelector('.skills-btn').addEventListener('click', (e) => {
                e.preventDefault(); // Prevent page reload

                Swal.fire({
                    title: 'Edit Skills',
                    html: `
                        <div>
                            <label for="skill-input" class="form-label">Add new skill:</label>
                            <input type="text" id="skill-input" class="form-control mb-2" placeholder="Type a skill...">
                        </div>
                        <h5 class="mt-4">Your Skills</h5>
                        <div id="added-skills" class="mt-2 text-center text-muted">
                            No skills have been added.
                        </div>
                    `,
                    confirmButtonText: 'Close',
                    customClass: {
                        confirmButton: 'btn btn-primary',
                    },
                    buttonsStyling: false,
                    didOpen: () => {
                        const skillInput = document.getElementById('skill-input');
                        const addedSkills = document.getElementById('added-skills');
                        const addedSkillList = [];

                        const updateAddedSkills = () => {
                            if (addedSkillList.length === 0) {
                                addedSkills.textContent = 'No skills have been added.';
                                addedSkills.classList.add('text-muted');
                            } else {
                                addedSkills.innerHTML = addedSkillList
                                    .map(
                                        (skill, index) =>
                                            `<span class="badge bg-primary text-white me-2">
                                                ${skill} <button type="button" class="btn-close btn-close-white btn-sm ms-1 remove-skill" data-index="${index}"></button>
                                            </span>`
                                    )
                                    .join('');
                                addedSkills.classList.remove('text-muted');
                            }
                        };

                        skillInput.addEventListener('input', (e) => {
                            // You can perform any validation or filtering here if needed
                        });

                        addedSkills.addEventListener('click', (e) => {
                            if (e.target.classList.contains('remove-skill')) {
                                const index = e.target.getAttribute('data-index');
                                addedSkillList.splice(index, 1);
                                updateAddedSkills();
                            }
                        });

                        skillInput.addEventListener('keydown', (e) => {
                            if (e.key === 'Enter') {
                                const skill = skillInput.value.trim();
                                if (skill.length > 0 && !addedSkillList.includes(skill)) {
                                    addedSkillList.push(skill);
                                    updateAddedSkills();
                                }
                                skillInput.value = '';
                                e.preventDefault();
                            }
                        });
                    },
                });
            });
        });
    </script>
@endsection