<?php

namespace Tests\Feature;

use App\Models\Firestring;
use App\Models\ShootingMatch;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FirestringEditTest extends TestCase
{
    use RefreshDatabase;

    public function test_firestring_can_be_saved_with_blank_legacy_fields(): void
    {
        $user = User::factory()->create();

        $match = ShootingMatch::create([
            'user_id' => $user->id,
            'place' => 'Test Match',
            'date' => '2026-07-10',
            'riflenumber' => 'TEST-1',
            'rangename' => 'Test Range',
        ]);

        $firestring = Firestring::create([
            'match_id' => $match->id,
            'fire_string_number' => 1,
            'distance' => '200 Yard Slow Fire',
            'target' => '',
            'relay' => '',
            'lightdirection' => '',
            'winddirection' => '',
            'windspeed' => 0,
            'elevation' => 0,
            'windage' => 0,
            'temperature' => '',
            'sky_condition' => '',
            'range_notes' => '',
        ]);

        $response = $this
            ->actingAs($user)
            ->post('/editfirestring/'.$firestring->id, [
                'id' => $firestring->id,
                'fire_string_number' => 1,
                'distance' => '200 Yard Slow Fire',
                'ballistic_profile_id' => null,
                'target' => '22',
                'relay' => null,
                'lightdirection' => null,
                'winddirection' => null,
                'windspeed' => null,
                'temperature' => null,
                'sky_condition' => null,
                'range_notes' => null,
                'elevation' => null,
                'windage' => null,
                'shot1value' => '10',
                'shot1x' => '251',
                'shot1y' => '245',
            ]);

        $response->assertRedirect(
            'indexfirestring/'.$match->id
        );

        $firestring->refresh();

        $this->assertSame('22', $firestring->target);
        $this->assertSame('', $firestring->relay);
        $this->assertSame('', $firestring->lightdirection);
        $this->assertSame('', $firestring->winddirection);
        $this->assertSame('', $firestring->temperature);
        $this->assertSame('', $firestring->sky_condition);
        $this->assertSame('', $firestring->range_notes);

        $this->assertSame('0', (string) $firestring->windspeed);
        $this->assertSame('0', (string) $firestring->elevation);
        $this->assertSame('0', (string) $firestring->windage);

        $this->assertSame('10', $firestring->shot1value);
        $this->assertSame('251', $firestring->shot1x);
        $this->assertSame('245', $firestring->shot1y);
    }
}
