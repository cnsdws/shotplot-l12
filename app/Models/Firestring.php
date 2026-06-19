<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Firestring extends Model
{
    protected $fillable = [
        'match_id',
        'fire_string_number',
        'distance',
        'target',
        'relay',
        'lightdirection',
        'winddirection',
        'windspeed',
        'elevation',
        'windage',
        'shot1value',
        'shot2value',
        'shot3value',
        'shot4value',
        'shot5value',
        'shot6value',
        'shot7value',
        'shot8value',
        'shot9value',
        'shot10value',
        'shot1x',
        'shot1y',
        'shot2x',
        'shot2y',
        'shot3x',
        'shot3y',
        'shot4x',
        'shot4y',
        'shot5x',
        'shot5y',
        'shot6x',
        'shot6y',
        'shot7x',
        'shot7y',
        'shot8x',
        'shot8y',
        'shot9x',
        'shot9y',
        'shot10x',
        'shot10y',
    ];

    public function match()
    {
        return $this->belongsTo(Match::class);
    }
}
