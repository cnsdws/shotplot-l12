<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rifle extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'caliber',
        'sight_type',
        'serial_number',
        'sight_click_moa',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function matches()
    {
        return $this->hasMany(ShootingMatch::class);
    }
    public function zeros()
    {
        return $this->hasMany(RifleZero::class);
    }
    
    public function defaultAmmos()
    {
        return $this->hasMany(RifleDefaultAmmo::class);
    }
}

