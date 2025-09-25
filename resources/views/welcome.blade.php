@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 animate-slide-in-left">
                <h1 class="display-3 fw-bold mb-4 text-shadow">Connect with Great Opportunities</h1>
                <p class="lead mb-4 fs-5">Work Connect bridges the gap between talented workers and forward-thinking employers. Find your next career move or discover exceptional talent.</p>
                <div class="d-flex gap-3 flex-wrap">
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg hover-lift">
                            <i class="fas fa-rocket me-2"></i>Get Started
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg hover-lift">
                            <i class="fas fa-sign-in-alt me-2"></i>Sign In
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg hover-lift">
                            <i class="fas fa-tachometer-alt me-2"></i>Go to Dashboard
                        </a>
                    @endguest
                </div>
            </div>
            <div class="col-lg-6 text-center animate-slide-in-right">
                <div class="position-relative">
                    <i class="fas fa-handshake text-white" style="font-size: 250px; opacity: 0.8;"></i>
                    <div class="position-absolute top-50 start-50 translate-middle">
                        <div class="bg-white rounded-circle p-3 animate-pulse" style="width: 80px; height: 80px;">
                            <i class="fas fa-users text-primary" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="row g-4">
        <div class="col-md-4 animate-fade-in-up" style="animation-delay: 0.1s;">
            <div class="card feature-card h-100 text-center p-4 hover-scale">
                <div class="card-body">
                    <div class="bg-gradient-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                        <i class="fas fa-user-tie fa-2x text-primary"></i>
                    </div>
                    <h4 class="text-gradient mb-3">For Workers</h4>
                    <p class="text-muted mb-4">Set your availability, receive job offers from employers, and work on projects that match your skills and location.</p>
                    <ul class="list-unstyled text-start">
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Set availability status</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Receive job offers</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Track work history</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 animate-fade-in-up" style="animation-delay: 0.2s;">
            <div class="card feature-card h-100 text-center p-4 hover-scale">
                <div class="card-body">
                    <div class="bg-gradient-secondary rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                        <i class="fas fa-building fa-2x text-secondary"></i>
                    </div>
                    <h4 class="text-gradient mb-3">For Employers</h4>
                    <p class="text-muted mb-4">Post job opportunities, send offers to available workers, and manage your workforce efficiently.</p>
                    <ul class="list-unstyled text-start">
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Post job listings</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Send job offers</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Manage active workers</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="col-md-4 animate-fade-in-up" style="animation-delay: 0.3s;">
            <div class="card feature-card h-100 text-center p-4 hover-scale">
                <div class="card-body">
                    <div class="bg-gradient-success rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                        <i class="fas fa-robot fa-2x text-success"></i>
                    </div>
                    <h4 class="text-gradient mb-3">AI-Powered Matching</h4>
                    <p class="text-muted mb-4">Our intelligent system matches workers with the best opportunities and helps employers find the right candidates.</p>
                    <ul class="list-unstyled text-start">
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Smart job recommendations</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Skill-based matching</li>
                        <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i>Performance insights</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-gradient-primary py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 animate-slide-in-left">
                <h2 class="mb-4 text-gradient">Why Choose Work Connect?</h2>
                <div class="row g-4">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center p-3 bg-white rounded-3 shadow-sm hover-lift">
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <i class="fas fa-shield-alt fa-lg text-white"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 fw-bold">Secure & Reliable</h5>
                                <p class="text-muted mb-0 small">Your data is protected</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center p-3 bg-white rounded-3 shadow-sm hover-lift">
                            <div class="bg-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <i class="fas fa-clock fa-lg text-white"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 fw-bold">Fast & Efficient</h5>
                                <p class="text-muted mb-0 small">Quick job offer process</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center p-3 bg-white rounded-3 shadow-sm hover-lift">
                            <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <i class="fas fa-users fa-lg text-white"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 fw-bold">Large Network</h5>
                                <p class="text-muted mb-0 small">Connect with many employers</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center p-3 bg-white rounded-3 shadow-sm hover-lift">
                            <div class="bg-danger rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                <i class="fas fa-headset fa-lg text-white"></i>
                            </div>
                            <div>
                                <h5 class="mb-1 fw-bold">24/7 Support</h5>
                                <p class="text-muted mb-0 small">Always here to help</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center animate-slide-in-right">
                <div class="position-relative">
                    <i class="fas fa-chart-line text-primary" style="font-size: 250px; opacity: 0.6;"></i>
                    <div class="position-absolute top-0 start-0">
                        <div class="bg-white rounded-circle p-3 shadow-lg animate-pulse" style="width: 60px; height: 60px;">
                            <i class="fas fa-arrow-up text-success" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                    <div class="position-absolute bottom-0 end-0">
                        <div class="bg-white rounded-circle p-3 shadow-lg animate-pulse" style="width: 60px; height: 60px; animation-delay: 0.5s;">
                            <i class="fas fa-arrow-up text-primary" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

