<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RifleDefaultAmmo extends Model
{
    protected $fillable = [
        'rifle_id',
        'distance',
        'ballistic_profile_id',
    ];

    public function rifle()
    {
        return $this->belongsTo(Rifle::class);
    }

    public function ballisticProfile()
    {
        return $this->belongsTo(BallisticProfile::class);
    }
}
