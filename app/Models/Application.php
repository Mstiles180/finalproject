<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_id', 'user_id', 'cover_letter', 'status',
    ];

    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeAccepted($query)
    {
        return $query->where('status', 'accepted');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => '<span class="badge bg-warning">Pending</span>',
            'accepted' => '<span class="badge bg-success">Accepted</span>',
            'rejected' => '<span class="badge bg-danger">Rejected</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }

    // AI Integration Placeholder Methods
    public function getAIScore()
    {
        // TODO: Implement AI-based application scoring
        // This will analyze cover letter, skills match, and other factors
        return 0.85; // Placeholder score
    }

    public function getRecommendationReason()
    {
        // TODO: Implement AI-based recommendation reasoning
        // This will provide insights on why this application was recommended
        return "Strong skill match and relevant experience"; // Placeholder
    }
} 