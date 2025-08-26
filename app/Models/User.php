<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'location',
        'category',
        'other_category',
                    'is_available',
            'daily_rate',
            'pickup_point_id',
            'province_id',
            'district_id',
            'sector_id',
            'cell_id',
            'village_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_available' => 'boolean',
        'daily_rate' => 'decimal:2',
    ];

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function jobOffers()
    {
        return $this->hasMany(JobOffer::class, 'worker_id');
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

    public function isWorker()
    {
        return $this->role === 'worker';
    }

    public function isBoss()
    {
        return $this->role === 'boss';
    }

    public function getAvailableWorkers($category = null, $pickupPointId = null)
    {
        $query = User::where('role', 'worker')
                    ->where('is_available', true)
                    ->whereDoesntHave('jobOffers', function($q) {
                        $q->where('status', 'accepted')
                          ->whereHas('job', function($jobQuery) {
                              $jobQuery->where('status', 'active')
                                      ->where('end_date', '>=', now()->toDateString());
                          });
                    });
        
        if ($category) {
            $query->where('category', $category);
        }
        
        if ($pickupPointId) {
            $query->where('pickup_point_id', $pickupPointId);
        }
        
        return $query->with('pickupPoint')->get();
    }

    public function isAvailableForWork()
    {
        return $this->is_available && $this->role === 'worker' && !$this->hasActiveJobs();
    }

    public function hasActiveJobs()
    {
        return $this->jobOffers()
            ->where('status', 'accepted')
            ->whereHas('job', function($query) {
                $query->where('status', 'active')
                      ->where('end_date', '>=', now()->toDateString());
            })
            ->exists();
    }

    public function getActiveJobs()
    {
        return $this->jobOffers()
            ->where('status', 'accepted')
            ->whereHas('job', function($query) {
                $query->where('status', 'active')
                      ->where('end_date', '>=', now()->toDateString());
            })
            ->with('job')
            ->get();
    }
}
