@extends('layouts.app')

@section('title', 'Post a Job')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card hover-scale">
                <div class="card-header">
                    <h4 class="mb-0 text-gradient"><i class="fas fa-plus me-2"></i>Post a New Job</h4>
                    <p class="text-muted mb-0 mt-2">Create a detailed job posting to attract the right workers</p>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('jobs.store') }}">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="title" class="form-label">
                                <i class="fas fa-tag me-2 text-primary"></i>Job Title *
                            </label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" 
                                   placeholder="Enter a clear and descriptive job title" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="description" class="form-label">
                                <i class="fas fa-align-left me-2 text-primary"></i>Job Description *
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="6" 
                                      placeholder="Describe the job responsibilities, requirements, and expectations..." required>{{ old('description') }}</textarea>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                Provide a detailed description of the role, responsibilities, and what you're looking for in a candidate.
                            </div>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="category" class="form-label">
                                <i class="fas fa-briefcase me-2 text-primary"></i>Work Category *
                            </label>
                            <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                                <option value="">Select work category</option>
                                <option value="laundry" {{ old('category') == 'laundry' ? 'selected' : '' }}>
                                    <i class="fas fa-tshirt me-2"></i>Laundry (Washing clothes)
                                </option>
                                <option value="builder" {{ old('category') == 'builder' ? 'selected' : '' }}>
                                    <i class="fas fa-hammer me-2"></i>Builder
                                </option>
                                <option value="builder_helper" {{ old('category') == 'builder_helper' ? 'selected' : '' }}>
                                    <i class="fas fa-tools me-2"></i>Builder Helper
                                </option>
                                <option value="farmer" {{ old('category') == 'farmer' ? 'selected' : '' }}>
                                    <i class="fas fa-seedling me-2"></i>Farmer
                                </option>
                                <option value="cleaner" {{ old('category') == 'cleaner' ? 'selected' : '' }}>
                                    <i class="fas fa-broom me-2"></i>Cleaner
                                </option>
                                <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>
                                    <i class="fas fa-ellipsis-h me-2"></i>Other
                                </option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3" id="other-category-field" style="display: none;">
                            <label for="other_category" class="form-label">Other Category</label>
                            <input type="text" class="form-control @error('other_category') is-invalid @enderror" 
                                   id="other_category" name="other_category" value="{{ old('other_category') }}" placeholder="Specify the work category">
                            @error('other_category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="location" class="form-label">Location *</label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                   id="location" name="location" value="{{ old('location') }}" required>
                            <div class="form-text">Specific location details (street, landmark, etc.)</div>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Administrative Location Fields -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="province_id" class="form-label">Province *</label>
                                    <select class="form-select @error('province_id') is-invalid @enderror" id="province_id" name="province_id" required>
                                        <option value="">Select Province</option>
                                        @foreach(\App\Models\Province::all() as $province)
                                            <option value="{{ $province->id }}" {{ old('province_id') == $province->id ? 'selected' : '' }}>
                                                {{ $province->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('province_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="district_id" class="form-label">District *</label>
                                    <select class="form-select @error('district_id') is-invalid @enderror" id="district_id" name="district_id" required>
                                        <option value="">Select District</option>
                                    </select>
                                    @error('district_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="sector_id" class="form-label">Sector *</label>
                                    <select class="form-select @error('sector_id') is-invalid @enderror" id="sector_id" name="sector_id" required>
                                        <option value="">Select Sector</option>
                                    </select>
                                    @error('sector_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="cell_id" class="form-label">Cell *</label>
                                    <select class="form-select @error('cell_id') is-invalid @enderror" id="cell_id" name="cell_id" required>
                                        <option value="">Select Cell</option>
                                    </select>
                                    @error('cell_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="village_id" class="form-label">Village *</label>
                                    <select class="form-select @error('village_id') is-invalid @enderror" id="village_id" name="village_id" required>
                                        <option value="">Select Village</option>
                                    </select>
                                    @error('village_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="pickup_point_id" class="form-label">Pickup Point *</label>
                            <select class="form-select @error('pickup_point_id') is-invalid @enderror" id="pickup_point_id" name="pickup_point_id" required>
                                <option value="">Select pickup point</option>
                            </select>
                            <div class="form-text">Select the pickup point where workers will meet for this job. Pickup points are filtered based on the selected village.</div>
                            @error('pickup_point_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Start Date *</label>
                                    <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                                           id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">End Date *</label>
                                    <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                                           id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="start_time" class="form-label">Start Time *</label>
                                    <input type="time" class="form-control @error('start_time') is-invalid @enderror" 
                                           id="start_time" name="start_time" value="{{ old('start_time') }}" required>
                                    @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <label for="end_time" class="form-label">End Time *</label>
                                    <input type="time" class="form-control @error('end_time') is-invalid @enderror" 
                                           id="end_time" name="end_time" value="{{ old('end_time') }}" required>
                                    @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Duration Info -->
                        <div class="alert alert-info" id="duration-info" style="display: none;">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Job Duration:</strong> <span id="duration-text"></span>
                            <br>
                            <small>This job will run for <span id="duration-days"></span> day(s) from <span id="start-date-text"></span> to <span id="end-date-text"></span></small>
                        </div>

                        <!-- Long-term Job Warning -->
                        <div class="alert alert-warning" id="long-term-warning" style="display: none;">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Long-term Job Alert:</strong> This is a long-term job that may last more than a week. 
                            Make sure to clearly communicate expectations with workers and consider breaking it into smaller tasks if possible.
                        </div>

                        <div class="mb-3">
                            <label for="daily_rate" class="form-label">Daily Rate (RWF) *</label>
                            <div class="input-group">
                                <span class="input-group-text">RWF</span>
                                <input type="number" class="form-control @error('daily_rate') is-invalid @enderror" 
                                       id="daily_rate" name="daily_rate" value="{{ old('daily_rate') }}" min="0" step="100" required>
                            </div>
                            <div class="form-text">Enter the daily rate in Rwandan Francs (RWF)</div>
                            @error('daily_rate')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Total Cost Calculation -->
                        <div class="alert alert-success" id="total-cost-info" style="display: none;">
                            <i class="fas fa-calculator me-2"></i>
                            <strong>Total Job Cost:</strong> <span id="total-cost"></span>
                            <br>
                            <small>Daily rate × Duration = Total cost</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Select Available Workers *</label>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                Select workers who are available for this type of work. They will receive job offers.
                            </div>
                            <div id="available-workers-container">
                                <div class="text-center">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Loading available workers...</span>
                                    </div>
                                    <p class="mt-2">Loading available workers...</p>
                                </div>
                            </div>
                            @error('selected_workers')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('jobs.index') }}" class="btn btn-outline-secondary hover-lift">
                                <i class="fas fa-arrow-left me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg hover-lift">
                                <i class="fas fa-paper-plane me-2"></i>Post Job
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('category');
    const otherCategoryField = document.getElementById('other-category-field');
    const locationInput = document.getElementById('location');
    const workersContainer = document.getElementById('available-workers-container');

    function toggleOtherCategory() {
        if (categorySelect.value === 'other') {
            otherCategoryField.style.display = 'block';
        } else {
            otherCategoryField.style.display = 'none';
        }
    }

    function calculateDuration() {
        const startDate = document.getElementById('start_date').value;
        const endDate = document.getElementById('end_date').value;
        const dailyRate = document.getElementById('daily_rate').value;
        
        if (startDate && endDate) {
            const start = new Date(startDate);
            const end = new Date(endDate);
            const diffTime = Math.abs(end - start);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
            
            const durationInfo = document.getElementById('duration-info');
            const longTermWarning = document.getElementById('long-term-warning');
            const totalCostInfo = document.getElementById('total-cost-info');
            
            if (diffDays > 1) {
                durationInfo.style.display = 'block';
                document.getElementById('duration-text').textContent = diffDays + ' day' + (diffDays > 1 ? 's' : '');
                document.getElementById('duration-days').textContent = diffDays;
                document.getElementById('start-date-text').textContent = start.toLocaleDateString();
                document.getElementById('end-date-text').textContent = end.toLocaleDateString();
                
                // Show long-term warning for jobs longer than 7 days
                if (diffDays > 7) {
                    longTermWarning.style.display = 'block';
                } else {
                    longTermWarning.style.display = 'none';
                }
            } else {
                durationInfo.style.display = 'none';
                longTermWarning.style.display = 'none';
            }

            // Calculate and show total cost
            if (dailyRate && dailyRate > 0) {
                const totalCost = dailyRate * diffDays;
                totalCostInfo.style.display = 'block';
                document.getElementById('total-cost').textContent = 'RWF ' + totalCost.toLocaleString();
            } else {
                totalCostInfo.style.display = 'none';
            }
        }
    }

    function loadAvailableWorkers() {
        const category = categorySelect.value;
        const pickupPointId = document.getElementById('pickup_point_id').value;
        const provinceId = document.getElementById('province_id').value;
        const districtId = document.getElementById('district_id').value;
        const sectorId = document.getElementById('sector_id').value;
        const cellId = document.getElementById('cell_id').value;
        const villageId = document.getElementById('village_id').value;

        if (!category) {
            workersContainer.innerHTML = '<div class="alert alert-warning">Please select a work category first.</div>';
            return;
        }

        if (!pickupPointId) {
            workersContainer.innerHTML = '<div class="alert alert-warning">Please select a pickup point first.</div>';
            return;
        }

        if (!provinceId || !districtId || !sectorId || !cellId || !villageId) {
            workersContainer.innerHTML = '<div class="alert alert-warning">Please select all administrative location fields first.</div>';
            return;
        }

        workersContainer.innerHTML = `
            <div class="text-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading available workers...</span>
                </div>
                <p class="mt-2">Loading available workers...</p>
            </div>
        `;

        const params = new URLSearchParams({
            category: category,
            pickup_point_id: pickupPointId,
            province_id: provinceId,
            district_id: districtId,
            sector_id: sectorId,
            cell_id: cellId,
            village_id: villageId
        });

        fetch(`/api/available-workers?${params}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
            .then(response => response.json())
            .then(data => {
                if (data.workers.length === 0) {
                    workersContainer.innerHTML = `
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            No available workers found for this category and location.
                        </div>
                    `;
                    return;
                }

                let html = '<div class="row">';
                data.workers.forEach(worker => {
                    html += `
                        <div class="col-md-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" 
                                       name="selected_workers[]" value="${worker.id}" 
                                       id="worker_${worker.id}">
                                <label class="form-check-label" for="worker_${worker.id}">
                                    <strong>${worker.name}</strong><br>
                                    <small class="text-muted">
                                        <i class="fas fa-map-marker-alt me-1"></i>${worker.location}<br>
                                        <i class="fas fa-money-bill me-1"></i>${worker.daily_rate} RWF/day<br>
                                        <i class="fas fa-phone me-1"></i>${worker.phone || 'No phone'}<br>
                                        <i class="fas fa-location-arrow me-1"></i>${worker.pickup_point ? worker.pickup_point.name : 'No pickup point'}
                                    </small>
                                </label>
                            </div>
                        </div>
                    `;
                });
                html += '</div>';
                workersContainer.innerHTML = html;
            })
            .catch(error => {
                workersContainer.innerHTML = `
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Error loading available workers. Please try again.
                    </div>
                `;
            });
    }

    // Cascading dropdown functionality
    function loadDistricts(provinceId) {
        const districtSelect = document.getElementById('district_id');
        districtSelect.innerHTML = '<option value="">Select District</option>';
        
        if (!provinceId) return;
        
        fetch(`/api/districts/${provinceId}`)
            .then(response => response.json())
            .then(data => {
                data.districts.forEach(district => {
                    const option = document.createElement('option');
                    option.value = district.id;
                    option.textContent = district.name;
                    districtSelect.appendChild(option);
                });
            });
    }

    function loadSectors(districtId) {
        const sectorSelect = document.getElementById('sector_id');
        sectorSelect.innerHTML = '<option value="">Select Sector</option>';
        
        if (!districtId) return;
        
        fetch(`/api/sectors/${districtId}`)
            .then(response => response.json())
            .then(data => {
                data.sectors.forEach(sector => {
                    const option = document.createElement('option');
                    option.value = sector.id;
                    option.textContent = sector.name;
                    sectorSelect.appendChild(option);
                });
            });
    }

    function loadCells(sectorId) {
        const cellSelect = document.getElementById('cell_id');
        cellSelect.innerHTML = '<option value="">Select Cell</option>';
        
        if (!sectorId) return;
        
        fetch(`/api/cells/${sectorId}`)
            .then(response => response.json())
            .then(data => {
                data.cells.forEach(cell => {
                    const option = document.createElement('option');
                    option.value = cell.id;
                    option.textContent = cell.name;
                    cellSelect.appendChild(option);
                });
            });
    }

    function loadVillages(cellId) {
        const villageSelect = document.getElementById('village_id');
        villageSelect.innerHTML = '<option value="">Select Village</option>';
        
        if (!cellId) return;
        
        fetch(`/api/villages/${cellId}`)
            .then(response => response.json())
            .then(data => {
                data.villages.forEach(village => {
                    const option = document.createElement('option');
                    option.value = village.id;
                    option.textContent = village.name;
                    villageSelect.appendChild(option);
                });
            });
    }

    function loadPickupPoints(villageId) {
        const pickupPointSelect = document.getElementById('pickup_point_id');
        pickupPointSelect.innerHTML = '<option value="">Select pickup point</option>';
        
        if (!villageId) return;
        
        fetch(`/api/pickup-points/${villageId}`)
            .then(response => response.json())
            .then(data => {
                data.pickup_points.forEach(pickupPoint => {
                    const option = document.createElement('option');
                    option.value = pickupPoint.id;
                    option.textContent = pickupPoint.name + ' - ' + pickupPoint.location_description;
                    pickupPointSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error loading pickup points:', error);
            });
    }

    // Event listeners for cascading dropdowns
    document.getElementById('province_id').addEventListener('change', function() {
        loadDistricts(this.value);
        // Reset dependent dropdowns
        document.getElementById('sector_id').innerHTML = '<option value="">Select Sector</option>';
        document.getElementById('cell_id').innerHTML = '<option value="">Select Cell</option>';
        document.getElementById('village_id').innerHTML = '<option value="">Select Village</option>';
        document.getElementById('pickup_point_id').innerHTML = '<option value="">Select pickup point</option>';
        loadAvailableWorkers();
    });

    document.getElementById('district_id').addEventListener('change', function() {
        loadSectors(this.value);
        // Reset dependent dropdowns
        document.getElementById('cell_id').innerHTML = '<option value="">Select Cell</option>';
        document.getElementById('village_id').innerHTML = '<option value="">Select Village</option>';
        document.getElementById('pickup_point_id').innerHTML = '<option value="">Select pickup point</option>';
        loadAvailableWorkers();
    });

    document.getElementById('sector_id').addEventListener('change', function() {
        loadCells(this.value);
        // Reset dependent dropdowns
        document.getElementById('village_id').innerHTML = '<option value="">Select Village</option>';
        document.getElementById('pickup_point_id').innerHTML = '<option value="">Select pickup point</option>';
        loadAvailableWorkers();
    });

    document.getElementById('cell_id').addEventListener('change', function() {
        loadVillages(this.value);
        // Reset pickup point dropdown
        document.getElementById('pickup_point_id').innerHTML = '<option value="">Select pickup point</option>';
        loadAvailableWorkers();
    });

    document.getElementById('village_id').addEventListener('change', function() {
        loadPickupPoints(this.value);
        loadAvailableWorkers();
    });

    // Date range event listeners
    document.getElementById('start_date').addEventListener('change', function() {
        calculateDuration();
        // Set end date minimum to start date
        document.getElementById('end_date').min = this.value;
        if (categorySelect.value) {
            loadAvailableWorkers();
        }
    });

    document.getElementById('end_date').addEventListener('change', function() {
        calculateDuration();
        if (categorySelect.value) {
            loadAvailableWorkers();
        }
    });

    document.getElementById('daily_rate').addEventListener('input', function() {
        calculateDuration();
    });

    categorySelect.addEventListener('change', function() {
        toggleOtherCategory();
        loadAvailableWorkers();
    });

    document.getElementById('pickup_point_id').addEventListener('change', function() {
        if (categorySelect.value) {
            loadAvailableWorkers();
        }
    });

    toggleOtherCategory(); // Initialize on page load
    // Don't load workers on page load since we need all location fields first
});
</script>
@endsection 