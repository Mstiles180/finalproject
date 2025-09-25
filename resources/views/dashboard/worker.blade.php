@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mt-4">
    <h1><i class="fas fa-tachometer-alt me-2"></i>Worker Dashboard</h1>
    
    <!-- Availability Status -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card {{ auth()->user()->is_available ? 'border-success' : 'border-warning' }}">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-1">
                                <i class="fas fa-toggle-{{ auth()->user()->is_available ? 'on' : 'off' }} me-2"></i>
                                Availability Status
                            </h5>
                            <p class="mb-0">
                                You are currently 
                                <span class="badge {{ auth()->user()->is_available ? 'bg-success' : 'bg-warning' }}">
                                    {{ auth()->user()->is_available ? 'Available' : 'Unavailable' }}
                                </span> 
                                for work
                            </p>
                        </div>
                        @if(auth()->user()->hasActiveJobs())
                            <div class="alert alert-warning mb-0">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Currently Working:</strong>
                                @foreach(auth()->user()->getActiveJobs() as $jobOffer)
                                    <br><small>{{ $jobOffer->job->title }} (until {{ $jobOffer->job->end_date->format('M d, Y') }})</small>
                                @endforeach
                            </div>
                        @elseif(auth()->user()->is_available)
                            <form method="POST" action="{{ route('toggle-availability') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-toggle-off me-2"></i>
                                    Be Unavailable
                                </button>
                            </form>
                        @else
                            @if(!auth()->user()->pickup_point_id)
                                <a href="{{ route('settings.profile') }}" class="btn btn-success">
                                    <i class="fas fa-map-marker-alt me-2"></i>
                                    Set Pickup Point to Be Available
                                </a>
                            @else
                                <form method="POST" action="{{ route('toggle-availability') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-toggle-on me-2"></i>
                                        Be Available
                                    </button>
                                </form>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4 animate-fade-in-up" style="animation-delay: 0.1s;">
            <div class="stats-card bg-primary text-white hover-lift">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-0 fw-bold">{{ $pendingJobOffers }}</h2>
                        <p class="mb-0 opacity-90">Pending Job Offers</p>
                    </div>
                    <div class="bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="fas fa-briefcase fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 animate-fade-in-up" style="animation-delay: 0.2s;">
            <div class="stats-card bg-success text-white hover-lift">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-0 fw-bold">{{ $acceptedJobOffers }}</h2>
                        <p class="mb-0 opacity-90">Accepted Offers</p>
                    </div>
                    <div class="bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="fas fa-check-circle fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 animate-fade-in-up" style="animation-delay: 0.3s;">
            <div class="stats-card bg-info text-white hover-lift">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-0 fw-bold">{{ $pendingJobOffers + $acceptedJobOffers }}</h2>
                        <p class="mb-0 opacity-90">Total Job Offers</p>
                    </div>
                    <div class="bg-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                        <i class="fas fa-bell fa-2x text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-search me-2"></i>Quick Actions</h5>
                    <div class="d-grid gap-2">
                        <a href="{{ route('job-offers.index') }}" class="btn btn-primary">
                            <i class="fas fa-briefcase me-2"></i>My Job Offers
                        </a>
                        <a href="{{ route('history.index') }}" class="btn btn-outline-success">
                            <i class="fas fa-history me-2"></i>Work History
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-robot me-2"></i>AI Recommendations</h5>
                    <p class="text-muted">Get personalized job recommendations based on your skills and preferences.</p>
                    <button class="btn btn-outline-info" onclick="showRecommendedJobs()">
                        <i class="fas fa-lightbulb me-2"></i>View Recommendations
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Jobs -->
    @if(auth()->user()->hasActiveJobs())
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="fas fa-briefcase me-2"></i>Currently Working On</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach(auth()->user()->getActiveJobs() as $jobOffer)
                        <div class="col-md-6 mb-3">
                            <div class="card border-success">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $jobOffer->job->title }}</h6>
                                    <p class="card-text">
                                        <strong>Employer:</strong> {{ $jobOffer->job->user->name }}<br>
                                        <strong>Location:</strong> {{ $jobOffer->job->location }}<br>
                                        <strong>Duration:</strong> {{ $jobOffer->job->duration_text }}<br>
                                        <strong>Date Range:</strong> {{ $jobOffer->job->date_range_text }}<br>
                                        <strong>Daily Rate:</strong> RWF {{ number_format($jobOffer->job->daily_rate, 0) }}<br>
                                        <strong>Total Earnings:</strong> {{ $jobOffer->job->total_amount }}
                                    </p>
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>Started: {{ $jobOffer->accepted_at->format('M d, Y') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Recent Job Offers -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Recent Job Offers</h5>
        </div>
        <div class="card-body">
            @if($pendingJobOffers > 0 || $acceptedJobOffers > 0)
                <div class="text-center py-4">
                    <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
                    <h5>You have job offers!</h5>
                    <p class="text-muted">Check your job offers to see new opportunities from employers.</p>
                    <a href="{{ route('job-offers.index') }}" class="btn btn-primary">
                        <i class="fas fa-briefcase me-2"></i>View Job Offers
                    </a>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-bell fa-3x text-muted mb-3"></i>
                    <h5>No job offers yet</h5>
                    <p class="text-muted">Make yourself available to receive job offers from employers!</p>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Tip:</strong> Update your availability status to receive job offers from employers in your area.
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Warnings Panel -->
    @if(isset($warnings) && $warnings->count())
        <div class="card mt-4">
            <div class="card-header bg-warning">
                <h5 class="mb-0"><i class="fas fa-triangle-exclamation me-2"></i>Warnings</h5>
            </div>
            <div class="card-body">
                <ul class="mb-0">
                    @foreach($warnings as $warning)
                        <li class="mb-2">
                            <strong>{{ $warning->created_at->format('M d, Y H:i') }}</strong> - {{ $warning->message }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- AI-Powered Recommendations Placeholder -->
    <div class="card mt-4" id="aiRecommendations" style="display: none;">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-robot me-2"></i>AI-Powered Job Recommendations</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <h6>Recommended Jobs Based on Your Profile</h6>
                    <div class="list-group">
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Senior Software Developer</h6>
                                <small class="text-muted">95% match</small>
                            </div>
                            <p class="mb-1">TechCorp Inc. - Remote</p>
                            <small class="text-muted">Skills: PHP, Laravel, MySQL, JavaScript</small>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Full Stack Developer</h6>
                                <small class="text-muted">88% match</small>
                            </div>
                            <p class="mb-1">StartupXYZ - New York</p>
                            <small class="text-muted">Skills: PHP, Laravel, Vue.js, AWS</small>
                        </div>
                        <div class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">Web Application Developer</h6>
                                <small class="text-muted">82% match</small>
                            </div>
                            <p class="mb-1">Digital Solutions - San Francisco</p>
                            <small class="text-muted">Skills: PHP, Laravel, React, Docker</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <h6>Profile Enhancement Suggestions</h6>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-plus-circle text-success me-2"></i>
                            Add more skills to your profile
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-certificate text-info me-2"></i>
                            Consider getting Laravel certification
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-project-diagram text-warning me-2"></i>
                            Showcase your portfolio projects
                        </li>
                    </ul>
                    <button class="btn btn-outline-primary btn-sm" onclick="showAIInsights()">
                        <i class="fas fa-chart-line me-2"></i>View Detailed Insights
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Enhancement Suggestions -->
    <div class="card mt-4" id="profileInsights" style="display: none;">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-chart-line me-2"></i>Profile Enhancement Suggestions</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h6>Skills Analysis</h6>
                    <div class="progress mb-3">
                        <div class="progress-bar" role="progressbar" style="width: 75%">PHP/Laravel: 75%</div>
                    </div>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 60%">JavaScript: 60%</div>
                    </div>
                    <div class="progress mb-3">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 45%">DevOps: 45%</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h6>Market Trends</h6>
                    <ul class="list-unstyled">
                        <li><i class="fas fa-arrow-up text-success me-2"></i>Laravel developers in high demand</li>
                        <li><i class="fas fa-arrow-up text-success me-2"></i>Remote work opportunities increasing</li>
                        <li><i class="fas fa-arrow-down text-warning me-2"></i>Consider learning React/Vue.js</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function showRecommendedJobs() {
    const recommendations = document.getElementById('aiRecommendations');
    if (recommendations.style.display === 'none') {
        recommendations.style.display = 'block';
    } else {
        recommendations.style.display = 'none';
    }
}

function showAIInsights() {
    const insights = document.getElementById('profileInsights');
    if (insights.style.display === 'none') {
        insights.style.display = 'block';
    } else {
        insights.style.display = 'none';
    }
}

// Cascading dropdown functionality for availability modal
document.addEventListener('DOMContentLoaded', function() {
    function loadDistricts(provinceId) {
        const districtSelect = document.getElementById('district_id');
        districtSelect.innerHTML = '<option value="">Select District</option>';
        
        if (!provinceId) return;
        
        console.log('Loading districts for province:', provinceId);
        
        fetch(`/api/districts/${provinceId}`)
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Districts data:', data);
                if (data.districts && data.districts.length > 0) {
                    data.districts.forEach(district => {
                        const option = document.createElement('option');
                        option.value = district.id;
                        option.textContent = district.name;
                        districtSelect.appendChild(option);
                    });
                } else {
                    console.log('No districts found');
                    districtSelect.innerHTML = '<option value="">No districts available</option>';
                }
            })
            .catch(error => {
                console.error('Error loading districts:', error);
                districtSelect.innerHTML = '<option value="">Error loading districts</option>';
            });
    }

    function loadSectors(districtId) {
        const sectorSelect = document.getElementById('sector_id');
        sectorSelect.innerHTML = '<option value="">Select Sector</option>';
        
        if (!districtId) return;
        
        console.log('Loading sectors for district:', districtId);
        
        fetch(`/api/sectors/${districtId}`)
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Sectors data:', data);
                if (data.sectors && data.sectors.length > 0) {
                    data.sectors.forEach(sector => {
                        const option = document.createElement('option');
                        option.value = sector.id;
                        option.textContent = sector.name;
                        sectorSelect.appendChild(option);
                    });
                } else {
                    console.log('No sectors found');
                    sectorSelect.innerHTML = '<option value="">No sectors available</option>';
                }
            })
            .catch(error => {
                console.error('Error loading sectors:', error);
                sectorSelect.innerHTML = '<option value="">Error loading sectors</option>';
            });
    }

    function loadCells(sectorId) {
        const cellSelect = document.getElementById('cell_id');
        cellSelect.innerHTML = '<option value="">Select Cell</option>';
        
        if (!sectorId) return;
        
        console.log('Loading cells for sector:', sectorId);
        
        fetch(`/api/cells/${sectorId}`)
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Cells data:', data);
                if (data.cells && data.cells.length > 0) {
                    data.cells.forEach(cell => {
                        const option = document.createElement('option');
                        option.value = cell.id;
                        option.textContent = cell.name;
                        cellSelect.appendChild(option);
                    });
                } else {
                    console.log('No cells found');
                    cellSelect.innerHTML = '<option value="">No cells available</option>';
                }
            })
            .catch(error => {
                console.error('Error loading cells:', error);
                cellSelect.innerHTML = '<option value="">Error loading cells</option>';
            });
    }

    function loadVillages(cellId) {
        const villageSelect = document.getElementById('village_id');
        villageSelect.innerHTML = '<option value="">Select Village</option>';
        
        if (!cellId) return;
        
        console.log('Loading villages for cell:', cellId);
        
        fetch(`/api/villages/${cellId}`)
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(data => {
                console.log('Villages data:', data);
                if (data.villages && data.villages.length > 0) {
                    data.villages.forEach(village => {
                        const option = document.createElement('option');
                        option.value = village.id;
                        option.textContent = village.name;
                        villageSelect.appendChild(option);
                    });
                } else {
                    console.log('No villages found');
                    villageSelect.innerHTML = '<option value="">No villages available</option>';
                }
            })
            .catch(error => {
                console.error('Error loading villages:', error);
                villageSelect.innerHTML = '<option value="">Error loading villages</option>';
            });
    }

    // Event listeners for cascading dropdowns in modal
    document.getElementById('province_id').addEventListener('change', function() {
        loadDistricts(this.value);
        // Reset dependent dropdowns
        document.getElementById('sector_id').innerHTML = '<option value="">Select Sector</option>';
        document.getElementById('cell_id').innerHTML = '<option value="">Select Cell</option>';
        document.getElementById('village_id').innerHTML = '<option value="">Select Village</option>';
    });

    document.getElementById('district_id').addEventListener('change', function() {
        loadSectors(this.value);
        // Reset dependent dropdowns
        document.getElementById('cell_id').innerHTML = '<option value="">Select Cell</option>';
        document.getElementById('village_id').innerHTML = '<option value="">Select Village</option>';
    });

    document.getElementById('sector_id').addEventListener('change', function() {
        loadCells(this.value);
        // Reset dependent dropdowns
        document.getElementById('village_id').innerHTML = '<option value="">Select Village</option>';
    });

    document.getElementById('cell_id').addEventListener('change', function() {
        loadVillages(this.value);
    });
});
</script>

<!-- Availability modal removed; setup pickup point in Settings instead. -->
@endsection 