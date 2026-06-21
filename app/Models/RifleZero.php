<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RifleZero extends Model
{
    protected $fillable = [
        'rifle_id',
        'distance',
        'elevation',
        'windage',
        'notes',
    ];

    public function rifle()
    {
        return $this->belongsTo(Rifle::class);
    }
}
