<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'description', 'category', 'other_category', 'location', 'start_date', 'end_date', 'start_time', 'end_time', 'duration_days', 'work_schedule', 'daily_rate', 'status', 'pickup_point_id',
        'province_id', 'district_id', 'sector_id', 'cell_id', 'village_id',
    ];

    protected $casts = [
        'daily_rate' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'work_schedule' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobOffers()
    {
        return $this->hasMany(JobOffer::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function pickupPoint()
    {
        return $this->belongsTo(PickupPoint::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function cell()
    {
        return $this->belongsTo(Cell::class);
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeWithAcceptedOffers($query)
    {
        return $query->whereHas('jobOffers', function($q) {
            $q->where('status', 'accepted');
        });
    }

    public function getTotalAmountAttribute()
    {
        // Calculate total amount based on duration
        $totalAmount = $this->daily_rate * $this->duration_days;
        return 'RWF ' . number_format($totalAmount, 0);
    }

    public function getTotalAmountNumericAttribute()
    {
        return $this->daily_rate * $this->duration_days;
    }

    public function getDurationTextAttribute()
    {
        if ($this->duration_days == 1) {
            return '1 day';
        } elseif ($this->duration_days < 7) {
            return $this->duration_days . ' days';
        } elseif ($this->duration_days < 30) {
            $weeks = ceil($this->duration_days / 7);
            return $weeks . ' week' . ($weeks > 1 ? 's' : '');
        } else {
            $months = ceil($this->duration_days / 30);
            return $months . ' month' . ($months > 1 ? 's' : '');
        }
    }

    public function getDateRangeTextAttribute()
    {
        if ($this->start_date->format('Y-m-d') === $this->end_date->format('Y-m-d')) {
            return $this->start_date->format('M d, Y');
        } else {
            return $this->start_date->format('M d, Y') . ' - ' . $this->end_date->format('M d, Y');
        }
    }

    public function isLongTermJob()
    {
        return $this->duration_days > 7;
    }

    public function isMultiDayJob()
    {
        return $this->duration_days > 1;
    }

    public function getAvailableWorkers()
    {
        return User::where('role', 'worker')
                    ->where('is_available', true)
                    ->where('category', $this->category)
                    ->where('pickup_point_id', $this->pickup_point_id)
                    ->with('pickupPoint')
                    ->get();
    }
} 