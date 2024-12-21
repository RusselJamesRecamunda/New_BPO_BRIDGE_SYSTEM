@extends('layouts.applicant_pages')

@section('title', 'BPO About Us')

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/about-us.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection

@section('about-us-content')
    <!-- Catalog Banner -->
    <div class="catalog-banner d-flex flex-column justify-content-center align-items-center">
        <h1 class="mt-1">About BPO Bridge</h1>
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        <div class="shape shape-4"></div>
    </div>

    <!-- About Us Section -->
    <div class="about-content container my-5">
        <div class="row align-items-center justify-content-center ">
            <!-- WHO WE ARE Section -->
            <div class="col-md-6 order-2 order-md-1" style="margin-top: -2%;">
                <h1 class="text-left">WHO WE ARE</h1>
                <p class="mt-4">BPO Bridge is a comprehensive job recruitment platform dedicated to bridging the gap between talented professionals and leading BPO companies. Our mission is to simplify the recruitment process, making it easier and more efficient for both job seekers and employers.</p>
                <p>We aim to connect the right people with the right jobs, helping them build their careers and support business growth.</p>
            </div>
            
            <!-- Image Section -->
            <div class="col-md-6 order-1 order-md-2">
                <img src="{{ asset('asset/img/catalog/about_image.png') }}" alt="Who We Are" class="img-fluid rounded">
            </div>
        </div>

        <h1 class="text-center mb-5" style="margin-top: 10%;">How It Works?</h1>
        <div class="row justify-content-center align-items-center" style="margin-bottom: 10%;">
            <div class="col d-flex flex-column justify-content-center align-items-center">
                <i class="fa fa-user text-primary fs-1 mb-3"></i>
                <h5 class="fw-bold fs-5">Create Account</h5>
                <p class="mt-3 text-center" style="font-size: 1rem;">Ensure all your personal details are up to date to enhance your profile visibility.</p>
            </div>
            <div class="col d-flex flex-column justify-content-center align-items-center">
                <i class="fa fa-search text-primary fs-1 mb-3"></i>
                <h5 class="fw-bold fs-5">Search Jobs</h5>
                <p class="mt-3 text-center" style="font-size: 1rem;">Explore a wide range of job opportunities that match your skills and interests.</p>
            </div>
            <div class="col d-flex flex-column justify-content-center align-items-center">
                <i class="fa fa-trophy text-primary fs-1 mb-3"></i>
                <h5 class="fw-bold fs-5">Apply</h5>
                <p class="mt-3 text-center" style="font-size: 1rem;">Submit your applications to potential jobs and take the next step in your career.</p>
            </div>
        </div>

        <div class="row align-items-center justify-content-center" style="margin-bottom: 8%;">
            <!-- Image Section -->
            <div class="col-md-6 order-1 order-md-1">
                <img src="{{ asset('asset/img/catalog/about_value.png') }}" alt="Who We Are" class="img-fluid rounded">
            </div>
            <!-- Our Value Section -->
           <div class="col-md-6 order-2 order-md-2 d-flex flex-column align-items-end text-end pe-5" style="margin-top: -5%;">
                <h1>Our Value</h1>
                <p class="mt-4">At BPO Bridge, we prioritize creating a transparent, reliable, and supportive environment for both job seekers and BPO companies. We aim to simplify the job recruitment process, making it easier for companies to find the right talent and for job seekers to find the right opportunities.</p>
                <p>Thank you for choosing BPO Bridge as your career partner. We’re here to help you navigate the BPO job market and support your professional growth every step of the way!</p>
            </div>
        </div>
    </div>    
@endsection
