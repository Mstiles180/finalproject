<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOffer extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id', 'worker_id', 'status', 'accepted_at', 'declined_at', 'completed_at',
        'rating', 'feedback', 'feedback_at',
    ];

    protected $casts = [
        'accepted_at' => 'datetime',
        'declined_at' => 'datetime',
        'completed_at' => 'datetime',
        'feedback_at' => 'datetime',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function worker()
    {
        return $this->belongsTo(User::class, 'worker_id');
    }

    // Remove incorrect employer method - use $jobOffer->job->user instead

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    public function scopeDeclined($query)
    {
        return $query->where('status', 'declined');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => '<span class="badge bg-warning">Pending</span>',
            'accepted' => '<span class="badge bg-success">Accepted</span>',
            'declined' => '<span class="badge bg-danger">Declined</span>',
            'completed' => '<span class="badge bg-info">Completed</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }

    public function hasFeedback()
    {
        return !is_null($this->rating) && !is_null($this->feedback);
    }

    public function getRatingStarsAttribute()
    {
        if (!$this->rating) {
            return '';
        }
        
        $stars = '';
        for ($i = 1; $i <= 5; $i++) {
            $stars .= '<i class="fas fa-star' . ($i <= $this->rating ? '' : '-o') . '"></i>';
        }
        return $stars;
    }
} 