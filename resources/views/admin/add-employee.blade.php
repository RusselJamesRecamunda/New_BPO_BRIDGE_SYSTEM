@extends('layouts.admin_pages')

@section('title', 'Add New Employee')

@section('browser-icon')
    <link rel="icon" href="{{ asset('asset/img/browser-icons/bpo_icon.png') }}" type="image/x-icon">
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/shares.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/css/add-employee.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.5/dist/sweetalert2.min.css">
@endsection

@section('add-employee-content')

    <!-- Top Bar -->
    @include('components.topbar')
    <h6 class="mt-3 mb-4  fw-bold text-primary" style="margin: -20px 0 0 5px;"><a href="{{ route('employees.index') }}" class="text-decoration-none" id="backButton">All Employees <i class="fa-solid fa-circle-chevron-left"></i> </a>New Employee Details</h6>
    <h2 class="mb-4 fw-bold text-primary" style="margin-top: -20px;"><i class="fa-solid fa-user-plus me-3"></i> Add New Employee</h2>
    <!-- Applicant Container -->
    <div class="emp-info-container mb-4">
        <!-- Tabs -->
        <div class="custom-tabs">
            <div class="custom-tab active" data-target="#personal-info">
                <i class="fa-solid fa-user-tie me-2"></i>Personal Information
            </div>
            <div class="custom-tab" data-target="#professional-info">
                <i class="fa-solid fa-suitcase me-2"></i>Professional Information
            </div>
            <div class="custom-tab" data-target="#document-info">
                <i class="fas fa-file-alt me-2"></i>Employee Documents
            </div>
        </div>
      
        <form method="POST" action="{{ route('add-employee.store') }}" enctype="multipart/form-data">
        @csrf
            <!-- Personal Info Content -->
            <div id="personal-info" class="tab-content" style="display: block;">
                <div class="container">
                <!-- Profile Picture -->
                    <div class="row mb-4 justify-content-start">
                        <div class="col-md-4">
                            <div class="profile-pic">
                                <img id="profile-img" name="profile-img" src="" alt="Profile Picture" class="rounded-circle">
                            </div>
                            <!-- Upload Button -->
                            <div class="mt-2">
                                <label for="profile-pic-upload" class="btn btn-primary fw-bold">
                                    <i class="fa-solid fa-circle-plus me-2"></i>Upload 2x2 Photo
                                </label>
                                <input type="file" id="profile-pic-upload" name="profile_img" style="display: none;" 
                                accept="image/png, image/jpeg" required>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Personal Information Form -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="first-name" class="form-label fw-bold">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="middle-name" class="form-label fw-bold">Middle Name</label>
                                    <input type="text" class="form-control" id="middle_name" name="middle_name" placeholder="Middle Name" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="last-name" class="form-label fw-bold">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Last Name" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="mobile-number" class="form-label fw-bold">Mobile Number</label>
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Mobile Number" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="email-address" class="form-label fw-bold">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email Address" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="dob" class="form-label fw-bold">Date of Birth</label>
                                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth">
                                </div>
                                <div class="col-md-6">
                                    <label for="marital-status" class="form-label fw-bold">Marital Status</label>
                                    <select class="form-select" id="marital_status" name="marital_status">
                                        <option selected>Choose...</option>
                                        <option value="single">Single</option>
                                        <option value="married">Married</option>
                                        <option value="divorced">Divorced</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="gender" class="form-label fw-bold">Gender</label>
                                    <select class="form-select" id="gender" name="gender">
                                        <option selected>Choose...</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="address" class="form-label fw-bold">Province</label>
                                    <input type="text" class="form-control" id="province" name="province" placeholder="Address" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="city" class="form-label fw-bold">City</label>
                                    <input type="text" class="form-control" id="city" name="city" placeholder="City" >
                                </div>
                                <div class="col-md-6">
                                    <label for="zip-code" class="form-label fw-bold">ZIP Code</label>
                                    <input type="text" class="form-control" id="zip-code" name="zip-code" placeholder="ZIP Code">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-end mt-4">
                                    <button type="button" class="btn btn-primary me-2" id="cancel-btn-1">Cancel</button>
                                    <button type="button" class="btn btn-primary" id="next-btn-1">Next</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Professional Info Content -->
            <div id="professional-info" class="tab-content mt-3" style="display: none;">
                <div class="container">
                    <!-- Professional Information Form -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                        
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="dept_manager" class="form-label fw-bold">Name of Department Manager</label>
                                    <input type="text" class="form-control" id="dept_manager" name="dept_manager" placeholder="Department Manager" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="date-hired" class="form-label fw-bold">Date Hired</label>
                                    <input type="date" class="form-control" id="hire_date" name="hire_date" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="official_emp_id" class="form-label fw-bold">Employee ID</label>
                                    <input type="text" class="form-control" id="official_emp_id" name="official_emp_id" placeholder="Employee ID" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="mst_account" class="form-label fw-bold">MS Team Account</label>
                                    <input type="text" class="form-control" id="mst_account" name="mst_account" placeholder="MS Team Account">
                                </div>
                                <div class="col-md-4">
                                    <label for="work_status" class="form-label fw-bold">Work Status</label>
                                    <select class="form-select" id="work_status" name="work_status" required>
                                        <option selected disabled>Choose...</option>
                                        @if (isset($workStatus) && $workStatus->isNotEmpty())
                                            @foreach ($workStatus as $status)
                                                <option value="{{ $status->job_type_name }}">{{ ucfirst($status->job_type_name) }}</option>
                                            @endforeach
                                        @else
                                            <option disabled>No work status available</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="email_address_prof" class="form-label fw-bold">Employee Email Address</label>
                                    <input type="email" class="form-control" id="emp_email" name="emp_email" placeholder="Employee Email Address" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="project_department" class="form-label fw-bold">Department</label>
                                    <select class="form-select" id="project_department" name="project_department" required>
                                        <option selected disabled>Choose...</option>
                                        @if (isset($companyDepartment) && $companyDepartment->isNotEmpty())
                                            @foreach ($companyDepartment as $department)
                                                <option value="{{ $department->category_name }}">{{ ucfirst($department->category_name) }}</option>
                                            @endforeach
                                        @else
                                            <option disabled>No departments available</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="working-days" class="form-label fw-bold">Working Days</label>
                                    <input type="text" class="form-control" id="working_days" name="working_days" placeholder="Working Days" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="designation" class="form-label fw-bold">Work Designation</label>
                                    <input type="text" class="form-control" id="designation" name="designation" placeholder="Designation" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-end mt-4">
                                    <button type="button" class="btn btn-primary me-2" id="back-btn-1">Back</button>
                                    <button type="button" class="btn btn-primary" id="next-btn-2">Next</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Employee Document Info Content -->
            <div id="document-info" class="tab-content" style="display: none;">
                <div class="container">
                    <!-- Document Upload Form -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h3 class="fw-bold text-center mt-2"><i class="fa-solid fa-file-import me-3"></i>Upload Required Documents</h3>
                            <div class="row">
                                <!-- Upload Birth Certificate -->
                                <div class="col-md-6 mb-4">
                                    <div class="border border-dotted rounded p-4 text-center position-relative" style="border-color: #4dabf7;">
                                        <div class="upload-icon text-center mb-3">
                                            <i class="fas fa-cloud-upload-alt" style="font-size: 40px; color: #0F5078;"></i>
                                        </div>
                                        <p class="mb-1 fw-bold">Upload Birth Certificate</p>
                                        <p class="mb-2 file-label">Drag & Drop or <a href="#" class="text-primary">choose file</a> to upload</p>
                                        <small class="text-muted">Supported formats: Jpeg, pdf</small>
                                        <input type="file" id="birth_cert" name="birth_cert" class="form-control-file file-input position-absolute w-100 h-100 top-0 start-0 opacity-0" accept=".pdf, .png, .jpeg, .jpg">
                                    </div>
                                </div>

                                <!-- Upload Phil Health -->
                                <div class="col-md-6 mb-4">
                                    <div class="border border-dotted rounded p-4 text-center position-relative" style="border-color: #4dabf7;">
                                        <div class="upload-icon text-center mb-3">
                                            <i class="fas fa-cloud-upload-alt" style="font-size: 40px; color: #0F5078;"></i>
                                        </div>
                                        <p class="mb-1 fw-bold">Upload Phil Health </p>
                                        <p class="mb-2  file-label">Drag & Drop or <a href="#" class="text-primary">choose file</a> to upload</p>
                                        <small class="text-muted">Supported formats: Jpeg, pdf</small>
                                        <input type="file" id="phil_health" name="phil_health" class="form-control-file file-input position-absolute w-100 h-100 top-0 start-0 opacity-0" id="salary-upload" accept=".pdf, .png, .jpeg, .jpg">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Upload SSS -->
                                <div class="col-md-6 mb-4">
                                    <div class="border border-dotted rounded p-4 text-center position-relative" style="border-color: #4dabf7;">
                                        <div class="upload-icon text-center mb-3">
                                            <i class="fas fa-cloud-upload-alt" style="font-size: 40px; color: #0F5078;"></i>
                                        </div>
                                        <p class="mb-1 fw-bold">Upload SSS</p>
                                        <p class="mb-2 file-label">Drag & Drop or <a href="#" class="text-primary">choose file</a> to upload</p>
                                        <small class="text-muted">Supported formats: Jpeg, pdf</small>
                                        <input type="file" id="sss" name="sss" class="form-control-file file-input position-absolute w-100 h-100 top-0 start-0 opacity-0" id="cover-upload" accept=".pdf, .png, .jpeg, .jpg">
                                    </div>
                                </div>

                                <!-- Upload Tin Number -->
                                <div class="col-md-6 mb-4">
                                    <div class="border border-dotted rounded p-4 text-center position-relative" style="border-color: #4dabf7;">
                                        <div class="upload-icon text-center mb-3">
                                            <i class="fas fa-cloud-upload-alt" style="font-size: 40px; color: #0F5078;"></i>
                                        </div>
                                        <p class="mb-1 fw-bold">Upload TIN Number</p>
                                        <p class="mb-2 file-label">Drag & Drop or <a href="#" class="text-primary">choose file</a> to upload</p>
                                        <small class="text-muted">Supported formats: Jpeg, pdf</small>
                                        <input type="file" id="tin_number" name="tin_number" class="form-control-file file-input position-absolute w-100 h-100 top-0 start-0 opacity-0" id="tin-upload" accept=".pdf, .png, .jpeg, .jpg">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Upload Pag-Ibig Fund Membership  -->
                                <div class="col-md-6 mb-4">
                                    <div class="border border-dotted rounded p-4 text-center position-relative" style="border-color: #4dabf7;">
                                        <div class="upload-icon text-center mb-3">
                                            <i class="fas fa-cloud-upload-alt" style="font-size: 40px; color: #0F5078;"></i>
                                        </div>
                                        <p class="mb-1 fw-bold">Upload Pag-Ibig Fund Membership</p>
                                        <p class="mb-2 file-label">Drag & Drop or <a href="#" class="text-primary">choose file</a> to upload</p>
                                        <small class="text-muted">Supported formats: Jpeg, pdf</small>
                                        <input type="file" id="pagibig_membership" name="pagibig_membership" class="form-control-file file-input position-absolute w-100 h-100 top-0 start-0 opacity-0" id="id-upload" accept=".pdf, .png, .jpeg, .jpg">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-end mt-4">
                                    <button type="button" class="btn btn-primary me-2" id="back-btn-2">Back</button>
                                    <button type="submit" class="btn btn-success fw-bold" id="submit-btn">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection

@section('scripts')
<script src="{{ asset('asset/js/add-employee.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
