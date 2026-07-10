<?php

namespace App\Models;

use App\Domains\Shot\Contracts\LegacyShotMapperInterface;
use App\Domains\Shot\DTOs\ShotCollection;
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
        'temperature',
        'sky_condition',
        'range_notes',
        'ballistic_profile_id',
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
        'shot11value',
        'shot12value',
        'shot13value',
        'shot14value',
        'shot15value',
        'shot16value',
        'shot17value',
        'shot18value',
        'shot19value',
        'shot20value',
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
        'shot11x',
        'shot11y',
        'shot12x',
        'shot12y',
        'shot13x',
        'shot13y',
        'shot14x',
        'shot14y',
        'shot15x',
        'shot15y',
        'shot16x',
        'shot16y',
        'shot17x',
        'shot17y',
        'shot18x',
        'shot18y',
        'shot19x',
        'shot19y',
        'shot20x',
        'shot20y',
    ];

    public function match()
    {
        return $this->belongsTo(
            ShootingMatch::class,
            'match_id'
        );
    }

    public function getShotCountAttribute(): int
    {
        return $this->distance === '600 Yard Slow Fire'
            ? 20
            : 10;
    }

    public function adjustments()
    {
        return $this->hasMany(
            FirestringAdjustment::class
        );
    }

    public function ballisticProfile()
    {
        return $this->belongsTo(
            BallisticProfile::class
        );
    }

    public function shots(): ShotCollection
    {
        return app(LegacyShotMapperInterface::class)
            ->fromFirestring($this);
    }

    public function totalScore(): int
    {
        return $this->shots()->totalScore();
    }

    public function xCount(): int
    {
        return $this->shots()->xCount();
    }

    public function formattedScore(): string
    {
        return $this->shots()->formattedScore();
    }
}
