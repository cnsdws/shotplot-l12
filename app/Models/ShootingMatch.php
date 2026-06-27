<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Rifle;

class ShootingMatch extends Model
{
    protected $table = 'matches';

    protected $fillable = [
        'user_id',
        'place',
        'date',
        'riflenumber',
        'rifle_id',
        'rangename',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function firestrings()
    {
        return $this->hasMany(Firestring::class, 'match_id')
            ->orderBy('fire_string_number');
    }
    public function rifle()
    {
        return $this->belongsTo(Rifle::class);
    }
}
