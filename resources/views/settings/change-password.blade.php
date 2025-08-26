@extends('layouts.app')

@section('title', 'Change Password')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-key me-2"></i>Change Password</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('settings.password.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password *</label>
                            <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                   id="current_password" name="current_password" required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">New Password *</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required minlength="8">
                            <div class="form-text">Password must be at least 8 characters long.</div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm New Password *</label>
                            <input type="password" class="form-control" 
                                   id="password_confirmation" name="password_confirmation" required minlength="8">
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('settings.profile') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Profile
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Password Requirements -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Password Requirements</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li><i class="fas fa-check text-success me-2"></i>At least 8 characters long</li>
                        <li><i class="fas fa-check text-success me-2"></i>Should be different from your current password</li>
                        <li><i class="fas fa-check text-success me-2"></i>Consider using a mix of letters, numbers, and symbols</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
