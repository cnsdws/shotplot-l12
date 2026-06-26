<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BallisticProfile extends Model
{
    protected $fillable = [
        'active',
        'user_id',
        'is_system',
        'display_order',

        'name',
        'type',

        'manufacturer',
        'manufacturer_product_number',
        'upc',

        'cartridge',
        'caliber',

        'bullet_manufacturer',
        'bullet_name',
        'bullet_weight',
        'bullet_style',

        'muzzle_velocity',
        'muzzle_energy',

        'g1_bc',
        'g7_bc',
        'sectional_density',

        'test_barrel_length',

        'case_type',
        'primer_type',

        'reloadable',
        'lead_free',
        'corrosive',

        'powder',
        'powder_charge',
        'primer',
        'brass',
        'overall_length',

        'lot_number',
        'purchase_date',

        'best_use',
        'country_of_origin',

        'notes',
    ];

    protected $casts = [
        'active' => 'boolean',
        'is_system' => 'boolean',
        'reloadable' => 'boolean',
        'lead_free' => 'boolean',
        'corrosive' => 'boolean',
        'purchase_date' => 'date',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function firestrings()
    {
        return $this->hasMany(Firestring::class);
    }
}
