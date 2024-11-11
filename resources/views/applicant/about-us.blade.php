@extends('layouts.applicant_pages')

@section('title', 'BPO About Us')

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/about-us.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection

@section('about-us-content')
    <!-- About Us Section -->
    <div class="about-content container my-5">
        <h2 class="text-center">About BPO Bridge</h2>
        
        <h3 class="mt-4 text-center">WHO WE ARE</h3>
        <p>BPO Bridge is a comprehensive job recruitment platform dedicated to bridging the gap between talented professionals and leading BPO companies. Our mission is to simplify the recruitment process, making it easier and more efficient for both job seekers and employers.</p>
        
        <h3 class="mt-4 text-center">With our platform, we aim to:</h3>
        <ul>
            <li><strong>Centralized Job Listings:</strong> Easy-to-navigate job postings for all available positions.</li>
            <li><strong>Document Management:</strong> Efficient handling of job application requirements.</li>
            <li><strong>Interview Scheduling System:</strong> Seamless coordination of interviews between candidates and hiring managers.</li>
            <li><strong>Contract Management:</strong> Streamlined process for finalizing employment agreements.</li>
            <li><strong>Reporting Tools:</strong> Generate comprehensive reports on hiring statistics and outcomes.</li>
        </ul>
    
        <h3 class="mt-4 text-center">Our Value</h3>
        <p class="mt-4 text-center">We believe in creating a transparent, reliable, and supportive environment for our users, fostering a culture of trust and collaboration.</p>
    
        <p class="mt-4 text-center">Thank you for choosing BPO Bridge as your career partner. We're excited to support you in reaching your professional goals!</p>
    </div>    
@endsection


