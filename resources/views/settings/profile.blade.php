@extends('layouts.app')

@section('title', 'Profile Settings')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-user-edit me-2"></i>Profile Settings</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('settings.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="border-bottom pb-2 mb-3">Basic Information</h5>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name *</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Address *</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                           id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        @if($user->role === 'worker')
                            <!-- Worker-specific Information -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2 mb-3">Worker Information</h5>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="daily_rate" class="form-label">Daily Rate (RWF)</label>
                                        <input type="number" class="form-control @error('daily_rate') is-invalid @enderror" 
                                               id="daily_rate" name="daily_rate" value="{{ old('daily_rate', $user->daily_rate) }}" min="0">
                                        @error('daily_rate')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="category" class="form-label">Work Category</label>
                                        <select class="form-select @error('category') is-invalid @enderror" id="category" name="category">
                                            <option value="">Select Category</option>
                                            <option value="laundry" {{ old('category', $user->category) === 'laundry' ? 'selected' : '' }}>Laundry</option>
                                            <option value="builder" {{ old('category', $user->category) === 'builder' ? 'selected' : '' }}>Builder</option>
                                            <option value="builder_helper" {{ old('category', $user->category) === 'builder_helper' ? 'selected' : '' }}>Builder Helper</option>
                                            <option value="farmer" {{ old('category', $user->category) === 'farmer' ? 'selected' : '' }}>Farmer</option>
                                            <option value="cleaner" {{ old('category', $user->category) === 'cleaner' ? 'selected' : '' }}>Cleaner</option>
                                            <option value="other" {{ old('category', $user->category) === 'other' ? 'selected' : '' }}>Other</option>
                                        </select>
                                        @error('category')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="other_category" class="form-label">Other Category (if applicable)</label>
                                        <input type="text" class="form-control @error('other_category') is-invalid @enderror" 
                                               id="other_category" name="other_category" value="{{ old('other_category', $user->other_category) }}">
                                        @error('other_category')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="location" class="form-label">General Location</label>
                                        <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                               id="location" name="location" value="{{ old('location', $user->location) }}" 
                                               placeholder="e.g., Kigali, Rwanda">
                                        @error('location')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Administrative Location: Province -> Village -->
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="province_id" class="form-label">Province</label>
                                        <select class="form-select @error('province_id') is-invalid @enderror" id="province_id" name="province_id">
                                            <option value="">Select Province</option>
                                            @foreach(\App\Models\Province::all() as $province)
                                                <option value="{{ $province->id }}" {{ old('province_id', $user->province_id) == $province->id ? 'selected' : '' }}>
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
                                        <label for="district_id" class="form-label">District</label>
                                        <select class="form-select @error('district_id') is-invalid @enderror" id="district_id" name="district_id">
                                            <option value="">Select District</option>
                                        </select>
                                        @error('district_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="sector_id" class="form-label">Sector</label>
                                        <select class="form-select @error('sector_id') is-invalid @enderror" id="sector_id" name="sector_id">
                                            <option value="">Select Sector</option>
                                        </select>
                                        @error('sector_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="cell_id" class="form-label">Cell</label>
                                        <select class="form-select @error('cell_id') is-invalid @enderror" id="cell_id" name="cell_id">
                                            <option value="">Select Cell</option>
                                        </select>
                                        @error('cell_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="village_id" class="form-label">Village</label>
                                        <select class="form-select @error('village_id') is-invalid @enderror" id="village_id" name="village_id">
                                            <option value="">Select Village</option>
                                        </select>
                                        @error('village_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="pickup_point_id" class="form-label">Pickup Point *</label>
                                        <select class="form-select @error('pickup_point_id') is-invalid @enderror" id="pickup_point_id" name="pickup_point_id" required>
                                            <option value="">Select pickup point</option>
                                        </select>
                                        @error('pickup_point_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Only pickup points assigned to the selected village will be shown.</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nid_image" class="form-label">National ID Image</label>
                                        <input type="file" class="form-control @error('nid_image') is-invalid @enderror" id="nid_image" name="nid_image" accept="image/*">
                                        @error('nid_image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @if($user->nid_image_url)
                                            <div class="mt-2">
                                                <img src="{{ asset($user->nid_image_url) }}" alt="NID" style="display:block; height:80px; width:auto; border-radius:4px; border:1px solid #ddd;">
                                                <a class="d-inline-block mt-1" href="{{ asset($user->nid_image_url) }}" target="_blank">Open</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="experience_image" class="form-label">Experience Image</label>
                                        <input type="file" class="form-control @error('experience_image') is-invalid @enderror" id="experience_image" name="experience_image" accept="image/*">
                                        @error('experience_image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @if($user->experience_image_url)
                                            <div class="mt-2">
                                                <img src="{{ asset($user->experience_image_url) }}" alt="Experience" style="display:block; height:80px; width:auto; border-radius:4px; border:1px solid #ddd;">
                                                <a class="d-inline-block mt-1" href="{{ asset($user->experience_image_url) }}" target="_blank">Open</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            
                        @endif

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Password Change Section -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-lock me-2"></i>Security</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">Change your password to keep your account secure.</p>
                    <a href="{{ route('settings.change-password') }}" class="btn btn-outline-primary">
                        <i class="fas fa-key me-2"></i>Change Password
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const provinceSelect = document.getElementById('province_id');
    const districtSelect = document.getElementById('district_id');
    const sectorSelect = document.getElementById('sector_id');
    const cellSelect = document.getElementById('cell_id');
    const villageSelect = document.getElementById('village_id');
    const pickupSelect = document.getElementById('pickup_point_id');

    function resetSelect(sel, placeholder) {
        if (!sel) return;
        sel.innerHTML = '<option value="">' + placeholder + '</option>';
    }

    function populateOptions(sel, rows) {
        if (!sel || !Array.isArray(rows)) return;
        for (const row of rows) {
            const opt = document.createElement('option');
            opt.value = row.id;
            opt.textContent = row.name;
            sel.appendChild(opt);
        }
    }

    async function fetchJson(url) {
        const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
        if (!res.ok) return {};
        try { return await res.json(); } catch { return {}; }
    }

    const initial = {
        provinceId: provinceSelect ? provinceSelect.value : '',
        districtId: '{{ old('district_id', $user->district_id) }}',
        sectorId: '{{ old('sector_id', $user->sector_id) }}',
        cellId: '{{ old('cell_id', $user->cell_id) }}',
        villageId: '{{ old('village_id', $user->village_id) }}',
    };

    async function onProvinceChange() {
        resetSelect(districtSelect, 'Select District');
        resetSelect(sectorSelect, 'Select Sector');
        resetSelect(cellSelect, 'Select Cell');
        resetSelect(villageSelect, 'Select Village');
        if (!provinceSelect.value) return;
        const data = await fetchJson(`/api/districts/${provinceSelect.value}`);
        populateOptions(districtSelect, data.districts || []);
        if (initial.districtId) {
            districtSelect.value = initial.districtId;
            initial.districtId = '';
            await onDistrictChange();
        }
    }

    async function onDistrictChange() {
        resetSelect(sectorSelect, 'Select Sector');
        resetSelect(cellSelect, 'Select Cell');
        resetSelect(villageSelect, 'Select Village');
        if (!districtSelect.value) return;
        const data = await fetchJson(`/api/sectors/${districtSelect.value}`);
        populateOptions(sectorSelect, data.sectors || []);
        if (initial.sectorId) {
            sectorSelect.value = initial.sectorId;
            initial.sectorId = '';
            await onSectorChange();
        }
    }

    async function onSectorChange() {
        resetSelect(cellSelect, 'Select Cell');
        resetSelect(villageSelect, 'Select Village');
        if (!sectorSelect.value) return;
        const data = await fetchJson(`/api/cells/${sectorSelect.value}`);
        populateOptions(cellSelect, data.cells || []);
        if (initial.cellId) {
            cellSelect.value = initial.cellId;
            initial.cellId = '';
            await onCellChange();
        }
    }

    async function onCellChange() {
        resetSelect(villageSelect, 'Select Village');
        resetSelect(pickupSelect, 'Select pickup point');
        if (!cellSelect.value) return;
        const data = await fetchJson(`/api/villages/${cellSelect.value}`);
        populateOptions(villageSelect, data.villages || []);
        if (initial.villageId) {
            villageSelect.value = initial.villageId;
            initial.villageId = '';
            await onVillageChange();
        }
    }

    async function onVillageChange() {
        resetSelect(pickupSelect, 'Select pickup point');
        if (!villageSelect.value) return;
        const data = await fetchJson(`/api/pickup-points/${villageSelect.value}`);
        populateOptions(pickupSelect, data.pickup_points || []);
        const savedPickup = '{{ old('pickup_point_id', $user->pickup_point_id) }}';
        if (savedPickup) pickupSelect.value = savedPickup;
    }

    if (provinceSelect) provinceSelect.addEventListener('change', onProvinceChange);
    if (districtSelect) districtSelect.addEventListener('change', onDistrictChange);
    if (sectorSelect) sectorSelect.addEventListener('change', onSectorChange);
    if (cellSelect) cellSelect.addEventListener('change', onCellChange);
    if (villageSelect) villageSelect.addEventListener('change', onVillageChange);

    // Preload saved chain once page loads
    if (initial.provinceId) {
        onProvinceChange();
    }
});
</script>
@endsection
