@extends('layouts.applicant_pages')

@section('title', 'Contact BPO-Bridge')

@section('styles')
    <link rel="stylesheet" href="{{ asset('asset/css/contact-us.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
@endsection

@section('contact-us-content')
    <!-- Catalog Banner -->
    <div class="catalog-banner d-flex flex-column justify-content-center align-items-center">
        <h1 class="mt-1">Contact Us</h1>
        <div class="shape shape-1"></div>
        <div class="shape shape-2"></div>
        <div class="shape shape-3"></div>
        <div class="shape shape-4"></div>
    </div>

    <div class="container py-2">
        <div class="contact-container">
            <!-- Contact Form -->
            <div class="contact-form">
                <h3 class="fw-bold">Get In Touch</h3>
                <form action="" method="POST">
                    @csrf
                    <div class= "mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Name" required>
                    </div>
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                    </div>
                    <div class="mb-3">
                        <textarea name="message" class="form-control" placeholder="Message" required></textarea>
                    </div>
                    <div class="text-end d-flex justify-content-center align-items-center">
                        <button type="submit" class="btn text-light w-50" style="background-color: #0F5078; font-size: 17px; font-weight:600;">
                        <i class="fa-regular fa-paper-plane me-3"></i>Submit</button>
                    </div>
                </form>
            </div>

            <!-- Contact Info -->
            <div class="contact-info">
                <div class="mb-2">
                    <h3 class="fw-bold" style="font-size: 1.75rem;">Contact Information</h3>
                    <p style="font-size: 1rem; line-height: 1.5;">
                        For inquiries or assistance, feel free to contact us. Whether it's about our services or partnership opportunities,
                        our team is ready to help. We'll get back to you as soon as possible.
                    </p>
                    <hr class="text-white">
                </div>
                <ul class="list-unstyled">
                    <li class="d-flex align-items-center mb-3" style="font-size: 1.125rem;">
                        <i class="fas fa-map-marker-alt me-3" style="font-size: 1.5rem;"></i>
                        <span>Sutherland Global Services, Legazpi City Port, 2nd Floor BPO Bldg. 4500 Albay</span>
                    </li>
                    <li class="d-flex align-items-center mb-3" style="font-size: 1.125rem;">
                        <i class="fas fa-phone-alt me-3" style="font-size: 1.5rem;"></i>
                        <span>09388541155</span>
                    </li>
                    <li class="d-flex align-items-center mb-" style="font-size: 1.125rem;">
                        <i class="fas fa-envelope me-3" style="font-size: 1.5rem;"></i>
                        <span>bpobridge2024@gmail.com</span>
                    </li>
                </ul>
                <hr class="text-white">
                <div class="">
                    <h5 style="font-size: 1.25rem;">Follow Us</h5>
                    <div class="social-icons" style="font-size: 1.5rem;">
                        <a href="https://www.facebook.com/LegazpiSiteCouncil" class="text-white me-3"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.linkedin.com/company/sutherland-global/" class="text-white me-3"><i class="fab fa-linkedin"></i></a>
                        <a href="https://www.instagram.com/sutherlandlifeapac/" class="text-white"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Section -->
    <div class="d-flex justify-content-center align-items-center mt-4">
        <div class="map-container">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3885.349717342366!2d123.76261019955744!3d13.140326885428028!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a101db77b57fdb%3A0x1cb46395f6b763fe!2sSutherland%20Global%20Services!5e0!3m2!1sen!2sph!4v1734274222258!5m2!1sen!2sph"
                width="600" height="400" frameborder="0"
                style="border:0;" allowfullscreen=""
                loading="lazy" referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
@endsection
