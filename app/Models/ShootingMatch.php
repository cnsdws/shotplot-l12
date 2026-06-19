<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShootingMatch extends Model
{
    protected $table = 'matches';

    protected $fillable = [
        'user_id',
        'place',
        'date',
        'riflenumber',
        'rangename',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function firestrings()
    {
        return $this->hasMany(Firestring::class, 'match_id');
    }
}
