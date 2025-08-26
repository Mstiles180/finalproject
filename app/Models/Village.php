<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'cell_id',
    ];

    public function cell()
    {
        return $this->belongsTo(Cell::class);
    }

    public function pickupPoints()
    {
        return $this->hasMany(PickupPoint::class);
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