<?php

namespace App\Domains\Firestring\Tests;

use App\Domains\Firestring\Contracts\FirestringServiceInterface;
use App\Models\Firestring;
use App\Models\ShootingMatch;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FirestringServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_service_resolves_from_container(): void
    {
        $service = app(FirestringServiceInterface::class);

        $this->assertInstanceOf(
            FirestringServiceInterface::class,
            $service
        );
    }

    public function test_it_normalizes_blank_legacy_fields(): void
    {
        $user = User::factory()->create();

        $match = ShootingMatch::create([
            'user_id' => $user->id,
            'place' => 'Test Match',
            'date' => '2026-07-10',
            'riflenumber' => '',
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
        ]);

        $service = app(FirestringServiceInterface::class);

        $updated = $service->update($firestring, [
            'target' => '22',
            'relay' => null,
            'lightdirection' => null,
            'winddirection' => null,
            'temperature' => null,
            'sky_condition' => null,
            'range_notes' => null,
            'windspeed' => null,
            'elevation' => null,
            'windage' => null,
            'shot1value' => '10',
        ]);

        $this->assertSame('22', $updated->target);
        $this->assertSame('', $updated->relay);
        $this->assertSame('', $updated->lightdirection);
        $this->assertSame('', $updated->winddirection);
        $this->assertSame('0', (string) $updated->windspeed);
        $this->assertSame('0', (string) $updated->elevation);
        $this->assertSame('0', (string) $updated->windage);
        $this->assertSame('10', $updated->shot1value);
    }

    public function test_it_ignores_unapproved_fields(): void
    {
        $user = User::factory()->create();

        $match = ShootingMatch::create([
            'user_id' => $user->id,
            'place' => 'Test Match',
            'date' => '2026-07-10',
            'riflenumber' => '',
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
        ]);

        $service = app(FirestringServiceInterface::class);

        $updated = $service->update($firestring, [
            'match_id' => 999,
            'target' => '12',
        ]);

        $this->assertSame($match->id, $updated->match_id);
        $this->assertSame('12', $updated->target);
    }
}
