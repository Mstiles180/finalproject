@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-body p-5">
                    <h2 class="text-center mb-4">Create Account</h2>
                    
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">I am a:</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input @error('role') is-invalid @enderror" 
                                               type="radio" name="role" id="worker" value="worker" 
                                               {{ old('role') == 'worker' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="worker">
                                            <i class="fas fa-user-tie me-2"></i>Worker (Job Seeker)
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input @error('role') is-invalid @enderror" 
                                               type="radio" name="role" id="boss" value="boss" 
                                               {{ old('role') == 'boss' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="boss">
                                            <i class="fas fa-building me-2"></i>Employer (Boss)
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @error('role')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Worker-specific fields -->
                        <div id="worker-fields" style="display: none;">
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone') }}" placeholder="Enter your phone number">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="location" class="form-label">Location</label>
                                <input type="text" class="form-control @error('location') is-invalid @enderror" 
                                       id="location" name="location" value="{{ old('location') }}" placeholder="Enter your location">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="category" class="form-label">Work Category</label>
                                <select class="form-select @error('category') is-invalid @enderror" id="category" name="category">
                                    <option value="">Select your work category</option>
                                    <option value="laundry" {{ old('category') == 'laundry' ? 'selected' : '' }}>Laundry (Washing clothes)</option>
                                    <option value="builder" {{ old('category') == 'builder' ? 'selected' : '' }}>Builder</option>
                                    <option value="builder_helper" {{ old('category') == 'builder_helper' ? 'selected' : '' }}>Builder Helper</option>
                                    <option value="farmer" {{ old('category') == 'farmer' ? 'selected' : '' }}>Farmer</option>
                                    <option value="cleaner" {{ old('category') == 'cleaner' ? 'selected' : '' }}>Cleaner</option>
                                    <option value="other" {{ old('category') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3" id="other-category-field" style="display: none;">
                                <label for="other_category" class="form-label">Other Category</label>
                                <input type="text" class="form-control @error('other_category') is-invalid @enderror" 
                                       id="other_category" name="other_category" value="{{ old('other_category') }}" placeholder="Specify your work category">
                                @error('other_category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                                <label for="daily_rate" class="form-label">Daily Rate (RWF)</label>
                <input type="number" step="100" class="form-control @error('daily_rate') is-invalid @enderror"
                    id="daily_rate" name="daily_rate" value="{{ old('daily_rate') }}" placeholder="Enter your daily rate in RWF">
                @error('daily_rate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">Create Account</button>
                    </form>
                    
                    <div class="text-center mt-4">
                        <p class="mb-0">Already have an account? <a href="{{ route('login') }}" class="text-decoration-none">Sign in here</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const workerRadio = document.getElementById('worker');
    const bossRadio = document.getElementById('boss');
    const workerFields = document.getElementById('worker-fields');
    const categorySelect = document.getElementById('category');
    const otherCategoryField = document.getElementById('other-category-field');

    // Show/hide worker fields based on role selection
    function toggleWorkerFields() {
        if (workerRadio.checked) {
            workerFields.style.display = 'block';
        } else {
            workerFields.style.display = 'none';
        }
    }

    // Show/hide other category field
    function toggleOtherCategory() {
        if (categorySelect.value === 'other') {
            otherCategoryField.style.display = 'block';
        } else {
            otherCategoryField.style.display = 'none';
        }
    }

    // Event listeners
    workerRadio.addEventListener('change', toggleWorkerFields);
    bossRadio.addEventListener('change', toggleWorkerFields);
    categorySelect.addEventListener('change', toggleOtherCategory);

    // Initialize on page load
    toggleWorkerFields();
    toggleOtherCategory();
});
</script>
@endsection 