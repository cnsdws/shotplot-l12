<?php

namespace App\Domains\MatchFactory\Tests;

use App\Domains\MatchFactory\Contracts\MatchFactoryServiceInterface;
use App\Models\Firestring;
use App\Models\ShootingMatch;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MatchFactoryIntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_nra_national_match_course_creates_expected_firestrings(): void
    {
        $user = User::factory()->create();

        $match = ShootingMatch::create([
            'user_id' => $user->id,
            'place' => 'Test Match',
            'date' => '2026-07-10',
            'riflenumber' => 'TEST-1',
            'rangename' => 'Test Range',
        ]);

        $factory = app(MatchFactoryServiceInterface::class);

        $created = $factory->generateFirestrings(
            $match,
            'nra-hp-national-match'
        );

        $this->assertCount(4, $created);
        $this->assertDatabaseCount('firestrings', 4);

        $firestrings = Firestring::query()
            ->where('match_id', $match->id)
            ->orderBy('fire_string_number')
            ->get();

        $this->assertSame(
            [1, 2, 3, 4],
            $firestrings
                ->pluck('fire_string_number')
                ->map(fn ($value) => (int) $value)
                ->all()
        );

        $this->assertSame(
            [
                '200 Yard Slow Fire',
                '200 Yard Rapid Fire',
                '300 Yard Rapid Fire',
                '600 Yard Slow Fire',
            ],
            $firestrings->pluck('distance')->all()
        );

        $this->assertSame(
            ['', '', '', ''],
            $firestrings->pluck('target')->all()
        );

        foreach ($firestrings as $firestring) {
            $this->assertSame('', $firestring->relay);
            $this->assertSame('', $firestring->lightdirection);
            $this->assertSame('', $firestring->winddirection);
            $this->assertSame('0', (string) $firestring->windspeed);
            $this->assertSame('0', (string) $firestring->elevation);
            $this->assertSame('0', (string) $firestring->windage);
        }
    }
}
