@extends('layouts.app')

@section('title', 'Give Feedback')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-star me-2"></i>Give Feedback
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6>Job Details</h6>
                            <p><strong>Title:</strong> {{ $jobOffer->job->title }}</p>
                            <p><strong>Worker:</strong> {{ $jobOffer->worker->name }}</p>
                            <p><strong>Completed:</strong> {{ $jobOffer->completed_at->format('M d, Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Job Description</h6>
                            <p>{{ $jobOffer->job->description }}</p>
                        </div>
                    </div>

                    <form action="{{ route('history.store-feedback', $jobOffer->id) }}" method="POST">
                        @csrf
                        
                        <div class="mb-4">
                            <label for="rating" class="form-label">
                                <strong>Rating <span class="text-danger">*</span></strong>
                            </label>
                            <div class="rating-input">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" name="rating" value="{{ $i }}" id="star{{ $i }}" class="rating-radio" required>
                                    <label for="star{{ $i }}" class="rating-star">
                                        <i class="fas fa-star"></i>
                                    </label>
                                @endfor
                            </div>
                            @error('rating')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="feedback" class="form-label">
                                <strong>Feedback <span class="text-danger">*</span></strong>
                            </label>
                            <textarea 
                                name="feedback" 
                                id="feedback" 
                                rows="5" 
                                class="form-control @error('feedback') is-invalid @enderror" 
                                placeholder="Share your experience working with this employee..."
                                required
                            >{{ old('feedback') }}</textarea>
                            @error('feedback')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                Your feedback helps other employers and helps the worker improve.
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('history.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Back to History
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane me-1"></i>Submit Feedback
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.rating-input {
    display: flex;
    flex-direction: row-reverse;
    gap: 5px;
}

.rating-radio {
    display: none;
}

.rating-star {
    font-size: 2rem;
    color: #ddd;
    cursor: pointer;
    transition: color 0.2s ease;
}

.rating-star:hover,
.rating-star:hover ~ .rating-star,
.rating-radio:checked ~ .rating-star {
    color: #ffc107;
}

.rating-input:hover .rating-star {
    color: #ddd;
}

.rating-input:hover .rating-star:hover,
.rating-input:hover .rating-star:hover ~ .rating-star {
    color: #ffc107;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ratingStars = document.querySelectorAll('.rating-star');
    const ratingRadios = document.querySelectorAll('.rating-radio');
    
    ratingStars.forEach((star, index) => {
        star.addEventListener('click', function() {
            // Uncheck all radios
            ratingRadios.forEach(radio => radio.checked = false);
            // Check the corresponding radio
            ratingRadios[4 - index].checked = true;
        });
    });
});
</script>
@endsection
