<?php

namespace Database\Seeders;

use App\Models\BallisticProfile;
use Illuminate\Database\Seeder;

class AmmoLoadSeeder extends Seeder
{
    public function run(): void
    {
        $profiles = [
            [
                'display_order' => 100,
                'name' => 'Hornady Match 75gr BTHP',
                'type' => 'Factory',
                'manufacturer' => 'Hornady',
                'manufacturer_product_number' => '81264',
                'upc' => '090255812640',
                'cartridge' => '5.56x45mm NATO',
                'caliber' => '5.56',
                'bullet_weight' => 75,
                'bullet_style' => 'Jacketed Hollow Point',
                'muzzle_velocity' => 2910,
                'muzzle_energy' => 1410,
                'g1_bc' => 0.395,
                'sectional_density' => 0.214,
                'test_barrel_length' => 20,
                'case_type' => 'Brass',
                'primer_type' => 'Boxer',
                'reloadable' => true,
                'lead_free' => false,
                'corrosive' => false,
                'best_use' => 'Range & Target',
                'country_of_origin' => 'United States',
            ],

            [
                'display_order' => 110,
                'name' => 'Federal Gold Medal Match 77gr SMK',
                'type' => 'Factory',
                'manufacturer' => 'Federal',
                'cartridge' => '.223 Remington',
                'caliber' => '.223',
                'bullet_manufacturer' => 'Sierra',
                'bullet_name' => 'MatchKing',
                'bullet_weight' => 77,
                'bullet_style' => 'BTHP',
                'case_type' => 'Brass',
                'primer_type' => 'Boxer',
                'reloadable' => true,
                'corrosive' => false,
                'best_use' => 'Match',
            ],

            [
                'display_order' => 120,
                'name' => 'Black Hills 77gr OTM',
                'type' => 'Factory',
                'manufacturer' => 'Black Hills',
                'cartridge' => '5.56x45mm NATO',
                'caliber' => '5.56',
                'bullet_weight' => 77,
                'bullet_style' => 'OTM',
                'case_type' => 'Brass',
                'reloadable' => true,
                'best_use' => 'Match',
            ],

            [
                'display_order' => 200,
                'name' => 'Federal Gold Medal Match 168gr SMK',
                'type' => 'Factory',
                'manufacturer' => 'Federal',
                'cartridge' => '.308 Winchester',
                'caliber' => '.308',
                'bullet_manufacturer' => 'Sierra',
                'bullet_name' => 'MatchKing',
                'bullet_weight' => 168,
                'bullet_style' => 'BTHP',
                'case_type' => 'Brass',
                'primer_type' => 'Boxer',
                'reloadable' => true,
                'corrosive' => false,
                'best_use' => 'Match',
            ],

            [
                'display_order' => 210,
                'name' => 'Federal Gold Medal Match 175gr SMK',
                'type' => 'Factory',
                'manufacturer' => 'Federal',
                'cartridge' => '.308 Winchester',
                'caliber' => '.308',
                'bullet_manufacturer' => 'Sierra',
                'bullet_name' => 'MatchKing',
                'bullet_weight' => 175,
                'bullet_style' => 'BTHP',
                'case_type' => 'Brass',
                'primer_type' => 'Boxer',
                'reloadable' => true,
                'corrosive' => false,
                'best_use' => 'Match',
            ],

            [
                'display_order' => 300,
                'name' => 'Hornady Match 140gr ELD Match',
                'type' => 'Factory',
                'manufacturer' => 'Hornady',
                'cartridge' => '6.5 Creedmoor',
                'caliber' => '6.5 Creedmoor',
                'bullet_manufacturer' => 'Hornady',
                'bullet_name' => 'ELD Match',
                'bullet_weight' => 140,
                'bullet_style' => 'Polymer Tip',
                'case_type' => 'Brass',
                'primer_type' => 'Boxer',
                'reloadable' => true,
                'corrosive' => false,
                'best_use' => 'Match',
            ],
        ];

        foreach ($profiles as $profile) {
            BallisticProfile::updateOrCreate(
                [
                    'name' => $profile['name'],
                    'user_id' => null,
                ],
                array_merge($profile, [
                    'user_id' => null,
                    'is_system' => true,
                    'active' => true,
                ])
            );
        }
    }
}
