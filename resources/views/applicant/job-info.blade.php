@extends('layouts.applicant_pages')

@section('title', 'Job Information')

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/about-us.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection

@section('job-info-content')
 <!-- Job Posting Section -->
 <div class="job-posting">
        <div class="header">
            <h2>Go further with Foundever™</h2>
            <p>Are you ready to move your career forward? At Foundever™, you will find our call center jobs surprising. We believe in memorable associate experiences. Here, you can improve your quality of life and grow your career.</p>
            <p>We believe that small moments can have a big impact on our work experiences, customers, teams, and friends. By creating positive moments for each other, we make a difference and improve our associate experience.</p>
        </div>

        <div class="role-section">
            <h3>Your Role as a Customer Support Agent:</h3>
            <p>As a Customer Support Agent, you will play a crucial role in providing exceptional customer service. Your responsibilities may include:</p>
            <ul>
                <li>Handling inbound calls and emails from customers</li>
                <li>Resolving customer inquiries and complaints efficiently</li>
                <li>Providing accurate information and solutions</li>
                <li>Navigating customer relationship management systems</li>
                <li>Adhering to quality standards and performance metrics</li>
            </ul>
        </div>

        <div class="qualifications-section">
            <h3>Qualifications:</h3>
            <ul>
                <li>Strong communication and interpersonal skills</li>
                <li>Basic computer proficiency</li>
                <li>A positive and can-do attitude</li>
                <li>Flexibility to work in a shift-based environment</li>
                <li>Willingness to undergo training and development</li>
            </ul>
        </div>

        <div class="benefits-section">
            <h3>What should you expect from us?</h3>
            <ul>
                <li>Competitive compensation and benefits</li>
                <li>Opportunities for growth and advancement</li>
                <li>Supportive team environment</li>
                <li>Comprehensive training and development programs</li>
                <li>A chance to make a positive impact on customers' lives</li>
            </ul>
        </div>

        <div class="footer">
            <div class="icon">
                <img src="{{ asset('asset/img/applicant/typework.png') }}" alt="Full Time">
                <span>Full Time</span>
            </div>
            <div class="icon">
                <img src="{{ asset('asset/img/applicant/work.png') }}" alt="Customer Service - Call Centre">
                <span>Customer Service - Call Centre</span>
            </div>
            <div class="icon">
                <img src="{{ asset('asset/img/applicant/building.png') }}" alt="On-site">
                <span>On-site</span>
            </div>
            <div class="icon">
                <img src="{{ asset('asset/img/applicant/salary.png') }}" alt="18k - 20k">
                <span>18k - 20k</span>
            </div>
        </div>

        <div class="call-to-action">
            <p>Ready to Start Your Journey?</p>
            <p>Apply now and take the first step towards a fulfilling career at Foundever™.</p>
            <button class="apply-btn">APPLY</button>
            <p class="application-deadline">Application ends in: <span id="countdown">3 days</span></p>
            <p>Unsure yet? Click Save to get back to it later.</p>
            <button class="save-btn">Save</button>
        </div>
    </div>    

@endsection

@section('scripts')
<!-- <script src="{{ asset('asset/js/add-employee.js') }}"></script> -->
@endsection
