<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FirestringAdjustment extends Model
{
    protected $fillable = [
        'firestring_id',
        'shot_number',
        'elevation_setting',
        'windage_setting',
        'notes',
    ];

    public function firestring()
    {
        return $this->belongsTo(Firestring::class);
    }
}
