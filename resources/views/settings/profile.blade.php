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
                    <form method="POST" action="{{ route('settings.profile.update') }}">
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
                        </div>

                        @if($user->role === 'worker')
                            <!-- Worker-specific Information -->
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h5 class="border-bottom pb-2 mb-3">Worker Information</h5>
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
