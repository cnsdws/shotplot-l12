<?php

namespace Database\Seeders;

use App\Models\BallisticProfile;
use Illuminate\Database\Seeder;

class AmmoLoadSeeder extends Seeder
{
    public function run(): void
    {
        $profiles = [
            // .223 / 5.56
            ['display_order'=>100,'name'=>'Hornady Match 68gr BTHP','type'=>'Factory','manufacturer'=>'Hornady','cartridge'=>'.223 Remington','caliber'=>'.223','bullet_manufacturer'=>'Hornady','bullet_name'=>'BTHP Match','bullet_weight'=>68,'bullet_style'=>'BTHP','case_type'=>'Brass','primer_type'=>'Boxer','reloadable'=>true,'corrosive'=>false,'best_use'=>'Match'],
            ['display_order'=>110,'name'=>'Hornady Match 75gr BTHP','type'=>'Factory','manufacturer'=>'Hornady','manufacturer_product_number'=>'81264','upc'=>'090255812640','cartridge'=>'5.56x45mm NATO','caliber'=>'5.56','bullet_weight'=>75,'bullet_style'=>'Jacketed Hollow Point','muzzle_velocity'=>2910,'muzzle_energy'=>1410,'g1_bc'=>0.395,'sectional_density'=>0.214,'test_barrel_length'=>20,'case_type'=>'Brass','primer_type'=>'Boxer','reloadable'=>true,'lead_free'=>false,'corrosive'=>false,'best_use'=>'Range & Target','country_of_origin'=>'United States'],
            ['display_order'=>120,'name'=>'Federal Gold Medal Match 69gr SMK','type'=>'Factory','manufacturer'=>'Federal','cartridge'=>'.223 Remington','caliber'=>'.223','bullet_manufacturer'=>'Sierra','bullet_name'=>'MatchKing','bullet_weight'=>69,'bullet_style'=>'BTHP','case_type'=>'Brass','primer_type'=>'Boxer','reloadable'=>true,'corrosive'=>false,'best_use'=>'Match'],
            ['display_order'=>130,'name'=>'Federal Gold Medal Match 77gr SMK','type'=>'Factory','manufacturer'=>'Federal','cartridge'=>'.223 Remington','caliber'=>'.223','bullet_manufacturer'=>'Sierra','bullet_name'=>'MatchKing','bullet_weight'=>77,'bullet_style'=>'BTHP','case_type'=>'Brass','primer_type'=>'Boxer','reloadable'=>true,'corrosive'=>false,'best_use'=>'Match'],
            ['display_order'=>140,'name'=>'Black Hills 69gr OTM','type'=>'Factory','manufacturer'=>'Black Hills','cartridge'=>'.223 Remington','caliber'=>'.223','bullet_weight'=>69,'bullet_style'=>'OTM','case_type'=>'Brass','reloadable'=>true,'best_use'=>'Match'],
            ['display_order'=>150,'name'=>'Black Hills 77gr OTM','type'=>'Factory','manufacturer'=>'Black Hills','cartridge'=>'5.56x45mm NATO','caliber'=>'5.56','bullet_weight'=>77,'bullet_style'=>'OTM','case_type'=>'Brass','reloadable'=>true,'best_use'=>'Match'],
            ['display_order'=>160,'name'=>'Black Hills Mk262 Mod 1 77gr OTM','type'=>'Factory','manufacturer'=>'Black Hills','cartridge'=>'5.56x45mm NATO','caliber'=>'5.56','bullet_weight'=>77,'bullet_style'=>'OTM','case_type'=>'Brass','reloadable'=>true,'best_use'=>'Match'],
            ['display_order'=>170,'name'=>'Lake City M193 55gr FMJ','type'=>'Factory','manufacturer'=>'Lake City','cartridge'=>'5.56x45mm NATO','caliber'=>'5.56','bullet_weight'=>55,'bullet_style'=>'FMJ','case_type'=>'Brass','primer_type'=>'Boxer','reloadable'=>true,'best_use'=>'Training'],
            ['display_order'=>180,'name'=>'Lake City M855 62gr SS109','type'=>'Factory','manufacturer'=>'Lake City','cartridge'=>'5.56x45mm NATO','caliber'=>'5.56','bullet_weight'=>62,'bullet_style'=>'FMJ','case_type'=>'Brass','primer_type'=>'Boxer','reloadable'=>true,'best_use'=>'Training'],

            // .308
            ['display_order'=>200,'name'=>'Federal Gold Medal Match 168gr SMK','type'=>'Factory','manufacturer'=>'Federal','cartridge'=>'.308 Winchester','caliber'=>'.308','bullet_manufacturer'=>'Sierra','bullet_name'=>'MatchKing','bullet_weight'=>168,'bullet_style'=>'BTHP','case_type'=>'Brass','primer_type'=>'Boxer','reloadable'=>true,'corrosive'=>false,'best_use'=>'Match'],
            ['display_order'=>210,'name'=>'Federal Gold Medal Match 175gr SMK','type'=>'Factory','manufacturer'=>'Federal','cartridge'=>'.308 Winchester','caliber'=>'.308','bullet_manufacturer'=>'Sierra','bullet_name'=>'MatchKing','bullet_weight'=>175,'bullet_style'=>'BTHP','case_type'=>'Brass','primer_type'=>'Boxer','reloadable'=>true,'corrosive'=>false,'best_use'=>'Match'],
            ['display_order'=>220,'name'=>'Hornady Match 168gr ELD Match','type'=>'Factory','manufacturer'=>'Hornady','cartridge'=>'.308 Winchester','caliber'=>'.308','bullet_manufacturer'=>'Hornady','bullet_name'=>'ELD Match','bullet_weight'=>168,'bullet_style'=>'Polymer Tip','case_type'=>'Brass','primer_type'=>'Boxer','reloadable'=>true,'corrosive'=>false,'best_use'=>'Match'],
            ['display_order'=>230,'name'=>'Hornady Match 178gr ELD Match','type'=>'Factory','manufacturer'=>'Hornady','cartridge'=>'.308 Winchester','caliber'=>'.308','bullet_manufacturer'=>'Hornady','bullet_name'=>'ELD Match','bullet_weight'=>178,'bullet_style'=>'Polymer Tip','case_type'=>'Brass','primer_type'=>'Boxer','reloadable'=>true,'corrosive'=>false,'best_use'=>'Match'],
            ['display_order'=>240,'name'=>'Black Hills 175gr SMK','type'=>'Factory','manufacturer'=>'Black Hills','cartridge'=>'.308 Winchester','caliber'=>'.308','bullet_manufacturer'=>'Sierra','bullet_name'=>'MatchKing','bullet_weight'=>175,'bullet_style'=>'BTHP','case_type'=>'Brass','reloadable'=>true,'best_use'=>'Match'],

            // 6.5 Creedmoor
            ['display_order'=>300,'name'=>'Hornady Match 140gr ELD Match','type'=>'Factory','manufacturer'=>'Hornady','cartridge'=>'6.5 Creedmoor','caliber'=>'6.5 Creedmoor','bullet_manufacturer'=>'Hornady','bullet_name'=>'ELD Match','bullet_weight'=>140,'bullet_style'=>'Polymer Tip','case_type'=>'Brass','primer_type'=>'Boxer','reloadable'=>true,'corrosive'=>false,'best_use'=>'Match'],
            ['display_order'=>310,'name'=>'Hornady Precision Hunter 143gr ELD-X','type'=>'Factory','manufacturer'=>'Hornady','cartridge'=>'6.5 Creedmoor','caliber'=>'6.5 Creedmoor','bullet_manufacturer'=>'Hornady','bullet_name'=>'ELD-X','bullet_weight'=>143,'bullet_style'=>'Polymer Tip','case_type'=>'Brass','primer_type'=>'Boxer','reloadable'=>true,'corrosive'=>false,'best_use'=>'Hunting'],
            ['display_order'=>320,'name'=>'Federal Gold Medal Berger 130gr Hybrid OTM','type'=>'Factory','manufacturer'=>'Federal','cartridge'=>'6.5 Creedmoor','caliber'=>'6.5 Creedmoor','bullet_manufacturer'=>'Berger','bullet_name'=>'Hybrid OTM','bullet_weight'=>130,'bullet_style'=>'OTM','case_type'=>'Brass','primer_type'=>'Boxer','reloadable'=>true,'best_use'=>'Match'],
            ['display_order'=>330,'name'=>'Berger Match 140gr Hybrid Target','type'=>'Factory','manufacturer'=>'Berger','cartridge'=>'6.5 Creedmoor','caliber'=>'6.5 Creedmoor','bullet_manufacturer'=>'Berger','bullet_name'=>'Hybrid Target','bullet_weight'=>140,'bullet_style'=>'Hybrid Target','case_type'=>'Brass','reloadable'=>true,'best_use'=>'Match'],
            ['display_order'=>340,'name'=>'Lapua Scenar 139gr','type'=>'Factory','manufacturer'=>'Lapua','cartridge'=>'6.5 Creedmoor','caliber'=>'6.5 Creedmoor','bullet_manufacturer'=>'Lapua','bullet_name'=>'Scenar','bullet_weight'=>139,'bullet_style'=>'Open Tip Match','case_type'=>'Brass','reloadable'=>true,'best_use'=>'Match'],

            // Hunting / general
            ['display_order'=>400,'name'=>'Hornady Precision Hunter 178gr ELD-X','type'=>'Factory','manufacturer'=>'Hornady','cartridge'=>'.308 Winchester','caliber'=>'.308','bullet_manufacturer'=>'Hornady','bullet_name'=>'ELD-X','bullet_weight'=>178,'bullet_style'=>'Polymer Tip','case_type'=>'Brass','primer_type'=>'Boxer','reloadable'=>true,'best_use'=>'Hunting'],
            ['display_order'=>410,'name'=>'Federal Premium Terminal Ascent .308','type'=>'Factory','manufacturer'=>'Federal','cartridge'=>'.308 Winchester','caliber'=>'.308','bullet_name'=>'Terminal Ascent','case_type'=>'Brass','primer_type'=>'Boxer','reloadable'=>true,'best_use'=>'Hunting'],
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
