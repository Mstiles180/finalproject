<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'district_id',
    ];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function cells()
    {
        return $this->hasMany(Cell::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
} 