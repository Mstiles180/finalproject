@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Connect with Great Opportunities</h1>
                <p class="lead mb-4">Work Connect bridges the gap between talented workers and forward-thinking employers. Find your next career move or discover exceptional talent.</p>
                <div class="d-flex gap-3">
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg">Get Started</a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">Sign In</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg">Go to Dashboard</a>
                    @endguest
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <i class="fas fa-handshake" style="font-size: 200px; opacity: 0.3;"></i>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card feature-card h-100 text-center p-4">
                <div class="card-body">
                    <i class="fas fa-user-tie fa-3x text-primary mb-3"></i>
                    <h4>For Workers</h4>
                    <p class="text-muted">Set your availability, receive job offers from employers, and work on projects that match your skills and location.</p>
                    <ul class="list-unstyled text-start">
                        <li><i class="fas fa-check text-success me-2"></i>Set availability status</li>
                        <li><i class="fas fa-check text-success me-2"></i>Receive job offers</li>
                        <li><i class="fas fa-check text-success me-2"></i>Track work history</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card feature-card h-100 text-center p-4">
                <div class="card-body">
                    <i class="fas fa-building fa-3x text-primary mb-3"></i>
                    <h4>For Employers</h4>
                    <p class="text-muted">Post job opportunities, send offers to available workers, and manage your workforce efficiently.</p>
                    <ul class="list-unstyled text-start">
                        <li><i class="fas fa-check text-success me-2"></i>Post job listings</li>
                        <li><i class="fas fa-check text-success me-2"></i>Send job offers</li>
                        <li><i class="fas fa-check text-success me-2"></i>Manage active workers</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card feature-card h-100 text-center p-4">
                <div class="card-body">
                    <i class="fas fa-robot fa-3x text-primary mb-3"></i>
                    <h4>AI-Powered Matching</h4>
                    <p class="text-muted">Our intelligent system matches workers with the best opportunities and helps employers find the right candidates.</p>
                    <ul class="list-unstyled text-start">
                        <li><i class="fas fa-check text-success me-2"></i>Smart job recommendations</li>
                        <li><i class="fas fa-check text-success me-2"></i>Skill-based matching</li>
                        <li><i class="fas fa-check text-success me-2"></i>Performance insights</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-light py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="mb-4">Why Choose Work Connect?</h2>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-shield-alt fa-2x text-primary me-3"></i>
                            <div>
                                <h5 class="mb-1">Secure & Reliable</h5>
                                <p class="text-muted mb-0">Your data is protected</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-clock fa-2x text-primary me-3"></i>
                            <div>
                                <h5 class="mb-1">Fast & Efficient</h5>
                                <p class="text-muted mb-0">Quick job offer process</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-users fa-2x text-primary me-3"></i>
                            <div>
                                <h5 class="mb-1">Large Network</h5>
                                <p class="text-muted mb-0">Connect with many employers</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-headset fa-2x text-primary me-3"></i>
                            <div>
                                <h5 class="mb-1">24/7 Support</h5>
                                <p class="text-muted mb-0">Always here to help</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <i class="fas fa-chart-line" style="font-size: 150px; color: #667eea; opacity: 0.3;"></i>
            </div>
        </div>
    </div>
</div>
@endsection
